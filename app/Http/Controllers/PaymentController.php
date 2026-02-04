<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $start = request()->input('start');
        $end = request()->input('end');
        $lapanganId = request()->input('lapangan');
        
        $query = Payment::with(['booking.user', 'booking.lapangan'])
            ->where('status', 'verified');
            
        if ($start && $end) {
            $query->whereHas('booking', function ($qb) use ($start, $end) {
                $qb->whereBetween('tanggal', [$start, $end]);
            });
        }
        
        if ($lapanganId) {
            $query->whereHas('booking', function ($qb) use ($lapanganId) {
                $qb->where('lapangan_id', $lapanganId);
            });
        }
        
        $payments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Calculate statistics
        $totalIncome = $payments->sum('jumlah');
        
        // Calculate bookings based on filter
        $bookingQuery = Booking::query();
        if ($start && $end) {
            $bookingQuery->whereBetween('tanggal', [$start, $end]);
        }
        
        $completedBookings = $bookingQuery->where('status', 'completed')->count();
        $pendingBookings = $bookingQuery->where('status', 'pending')->count();
        $avgTransaction = $payments->count() > 0 ? $totalIncome / $payments->count() : 0;
        
        // Revenue by lapangan
        $byLapangan = $payments->groupBy(function ($p) {
            return $p->booking->lapangan->nama ?? 'Unknown';
        })->map(function ($group) {
            return $group->sum('jumlah');
        });
        
        // Get all lapangan for filter
        $lapangans = Lapangan::all();
        
        // Monthly revenue data for chart - show all data if no filter
        $monthlyRevenueQuery = Payment::where('status', 'verified')
            ->selectRaw('MONTH(created_at) as month, SUM(jumlah) as total');
            
        if ($start && $end) {
            $monthlyRevenueQuery->whereHas('booking', function ($qb) use ($start, $end) {
                $qb->whereBetween('tanggal', [$start, $end]);
            });
        } else {
            $monthlyRevenueQuery->whereYear('created_at', now()->year);
        }
        
        $monthlyRevenue = $monthlyRevenueQuery
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
        
        // Debug logging
        \Log::info('Keuangan data loaded', [
            'payments_count' => $payments->count(),
            'total_income' => $totalIncome,
            'monthly_revenue' => $monthlyRevenue,
            'by_lapangan' => $byLapangan->toArray()
        ]);
        
        return view('keuangan.index', compact(
            'payments',
            'totalIncome',
            'completedBookings', 
            'pendingBookings',
            'avgTransaction',
            'byLapangan',
            'lapangans',
            'monthlyRevenue',
            'start',
            'end',
            'lapanganId'
        ));
    }

    public function uploadProof(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Check authorization
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);
        
        $payment = $booking->payment;
        if (!$payment) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'jumlah' => $booking->total_harga,
                'metode_pembayaran' => 'transfer_bank',
                'status' => 'pending',
            ]);
        }
        
        if ($payment->bukti_pembayaran) {
            Storage::disk('public')->delete($payment->bukti_pembayaran);
        }
        
        $path = $request->file('bukti_pembayaran')->store('payments', 'public');
        $payment->update([
            'bukti_pembayaran' => $path,
            'status' => 'pending',
        ]);
        
        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'payment_uploaded',
            'description' => 'Upload bukti pembayaran untuk booking ' . $booking->id,
            'ip_address' => $request->ip(),
        ]);
        
        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    public function verify($id)
    {
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $payment = Payment::with('booking')->findOrFail($id);
        
        $payment->update(['status' => 'verified']);
        
        // Auto confirm booking jika payment verified
        if ($payment->booking && $payment->booking->status === 'pending') {
            $payment->booking->update(['status' => 'confirmed']);
        }
        
        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'payment_verified',
            'description' => 'Memverifikasi pembayaran untuk booking ' . $payment->booking_id,
            'ip_address' => request()->ip(),
        ]);
        
        return back()->with('success', 'Pembayaran berhasil diverifikasi dan booking dikonfirmasi');
    }

    public function rejectPayment($id)
    {
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $payment = Payment::with('booking')->findOrFail($id);
        
        $payment->update(['status' => 'rejected']);
        
        // Reject booking jika payment rejected
        if ($payment->booking) {
            $payment->booking->update(['status' => 'rejected']);
        }
        
        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'payment_rejected',
            'description' => 'Menolak pembayaran untuk booking ' . $payment->booking_id,
            'ip_address' => request()->ip(),
        ]);
        
        return back()->with('success', 'Pembayaran ditolak dan booking dibatalkan');
    }
}
