<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

    public function exportPDF(Request $request)
    {
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $start = $request->input('start');
        $end = $request->input('end');
        $lapanganId = $request->input('lapangan');
        
        // Get payments data
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
        
        $payments = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics
        $totalIncome = $payments->sum('jumlah');
        
        // Create PDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        
        $html = view('keuangan.pdf', compact('payments', 'totalIncome', 'start', 'end', 'lapanganId'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $filename = 'laporan-keuangan-' . date('Y-m-d') . '.pdf';
        return $dompdf->stream($filename);
    }

    public function exportExcel(Request $request)
    {
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $start = $request->input('start');
        $end = $request->input('end');
        $lapanganId = $request->input('lapangan');
        
        // Get payments data
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
        
        $payments = $query->orderBy('created_at', 'desc')->get();
        
        // Create Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        
        // Set period
        $period = 'Periode: ';
        if ($start && $end) {
            $period .= $start . ' s/d ' . $end;
        } else {
            $period .= 'Semua Data';
        }
        $sheet->setCellValue('A2', $period);
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        
        // Headers
        $headers = ['Tanggal', 'Kode Booking', 'Customer', 'Lapangan', 'Jam', 'Total', 'Status', 'Payment'];
        $sheet->fromArray($headers, null, 'A4');
        
        // Style headers
        $headerStyle = $sheet->getStyle('A4:H4');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setARGB('FFE0E0E0');
        $headerStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Data
        $row = 5;
        $totalIncome = 0;
        
        foreach ($payments as $payment) {
            $sheet->setCellValue('A' . $row, $payment->created_at->format('Y-m-d'));
            $sheet->setCellValue('B' . $row, 'BK' . str_pad($payment->booking_id, 3, '0', STR_PAD_LEFT));
            $sheet->setCellValue('C' . $row, $payment->booking->user->name ?? 'Unknown');
            $sheet->setCellValue('D' . $row, $payment->booking->lapangan->nama ?? 'Unknown');
            
            $jam = '-';
            if ($payment->booking->jam_mulai && $payment->booking->jam_selesai) {
                $jam = \Carbon\Carbon::parse($payment->booking->jam_mulai)->format('H:i') . '-' . 
                       \Carbon\Carbon::parse($payment->booking->jam_selesai)->format('H:i');
            }
            $sheet->setCellValue('E' . $row, $jam);
            
            $sheet->setCellValue('F' . $row, $payment->jumlah);
            $sheet->setCellValue('G' . $row, ucfirst($payment->booking->status ?? ''));
            $sheet->setCellValue('H' . $row, ucfirst($payment->status));
            
            // Style data row
            $sheet->getStyle('A' . $row . ':H' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            
            $totalIncome += $payment->jumlah;
            $row++;
        }
        
        // Total
        $sheet->setCellValue('E' . ($row + 1), 'TOTAL:');
        $sheet->setCellValue('F' . ($row + 1), $totalIncome);
        $sheet->getStyle('E' . ($row + 1) . ':F' . ($row + 1))->getFont()->setBold(true);
        $sheet->getStyle('E' . ($row + 1) . ':F' . ($row + 1))->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('E' . ($row + 1) . ':F' . ($row + 1))->getFill()->getStartColor()->setARGB('FFE0E0E0');
        
        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Format currency column
        $sheet->getStyle('F' . '5:F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . ($row + 1))->getNumberFormat()->setFormatCode('#,##0');
        
        $filename = 'laporan-keuangan-' . date('Y-m-d') . '.xlsx';
        
        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
