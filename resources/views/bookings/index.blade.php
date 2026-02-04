@extends('layouts.app')

@section('title', Auth::user()->isCustomer() ? 'Booking Saya' : (Auth::user()->isManager() ? 'Konfirmasi Booking' : 'Semua Booking'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>
            <i class="fas fa-calendar-check me-2"></i>
            @if(Auth::user()->isCustomer())
                Booking Saya
            @elseif(Auth::user()->isManager())
                Konfirmasi Booking
            @else
                Semua Booking
            @endif
        </h5>
        <div>
            @if(Auth::user()->isCustomer())
                <a href="{{ route('bookings.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Buat Booking
                </a>
            @endif
            <button class="btn btn-primary" onclick="refreshData()">
                <i class="fas fa-sync me-2"></i>Refresh
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border border-warning shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-warning"><i class="fas fa-clock me-2"></i>Pending</h5>
                        <h3 class="mb-0 text-dark">{{ $pendingCount ?? 0 }}</h3>
                        <small class="text-muted">Menunggu Konfirmasi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border border-success shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-success"><i class="fas fa-check-circle me-2"></i>Confirmed</h5>
                        <h3 class="mb-0 text-dark">{{ $confirmedCount ?? 0 }}</h3>
                        <small class="text-muted">Dikonfirmasi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border border-danger shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-danger"><i class="fas fa-times-circle me-2"></i>Rejected</h5>
                        <h3 class="mb-0 text-dark">{{ $rejectedCount ?? 0 }}</h3>
                        <small class="text-muted">Ditolak</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border border-info shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-info"><i class="fas fa-calendar-day me-2"></i>Today</h5>
                        <h3 class="mb-0 text-dark">{{ $todayCount ?? 0 }}</h3>
                        <small class="text-muted">Booking Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select class="form-select" id="filter-status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" id="filter-tanggal" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filter-lapangan">
                    <option value="">Semua Lapangan</option>
                    @foreach($lapangans ?? [] as $lapangan)
                        <option value="{{ $lapangan->id }}" {{ request('lapangan_id') == $lapangan->id ? 'selected' : '' }}>{{ $lapangan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="search-booking" placeholder="Cari booking..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="button" onclick="searchBooking()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        @if(!Auth::user()->isCustomer())
                            <th>Customer</th>
                        @endif
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="{{ $booking->status === 'confirmed' ? 'table-success' : ($booking->status === 'pending' ? 'table-warning' : ($booking->status === 'rejected' ? 'table-danger' : '')) }}">
                            <td><span class="badge bg-primary">BK{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                            @if(!Auth::user()->isCustomer())
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($booking->user->name ?? '-', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div>{{ $booking->user->name ?? '-' }}</div>
                                            <small class="text-muted">{{ $booking->user->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            <td>{{ $booking->lapangan->nama ?? '-' }}</td>
                            <td>{{ $booking->tanggal ? $booking->tanggal->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($booking->jam_mulai && $booking->jam_selesai)
                                    {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $booking->total_harga ? formatRupiah($booking->total_harga) : '-' }}</td>
                            <td>{!! getStatusBadge($booking->status) !!}</td>
                            <td>
                                @if($booking->payment)
                                    <span class="badge bg-{{ $booking->payment->status === 'verified' ? 'success' : ($booking->payment->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($booking->payment->status) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $booking->payment->metode_pembayaran ?? '-')) }}</small>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                    <br>
                                    <small class="text-muted">Belum upload</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" onclick="showDetailModal({{ $booking->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if(Auth::user()->isManager() || Auth::user()->isAdmin())
                                        @if($booking->payment && $booking->payment->status === 'pending' && $booking->status === 'pending')
                                            <form action="{{ route('payments.verify', $booking->payment->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                <button class="btn btn-success" type="submit" onclick="return confirm('Verifikasi pembayaran dan konfirmasi booking?')" title="Verifikasi Pembayaran">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('payments.reject', $booking->payment->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Tolak pembayaran ini?')" title="Tolak Pembayaran">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @elseif($booking->status === 'pending' && (!$booking->payment || $booking->payment->status === 'verified'))
                                            <form action="{{ route('bookings.confirm', $booking->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-success" type="submit" onclick="return confirm('Konfirmasi booking ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-danger" onclick="rejectBookingClient({{ $booking->id }})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        @if($booking->status === 'confirmed')
                                            <form action="{{ route('bookings.complete', $booking->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-primary" type="submit" onclick="return confirm('Tandai booking sebagai selesai?')">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                    @if(Auth::user()->isCustomer() && $booking->canBeCancelled())
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-warning" type="submit" onclick="return confirm('Batalkan booking ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isCustomer() ? '8' : '9' }}" class="text-center">Belum ada booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail-content">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 12px;
}

/* Payment proof image hover effect */
.payment-proof-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function formatRupiah(amount) {
    if (!amount) return '-';
    return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Global variable untuk modal
let detailModal = null;

// Initialize modal saat document ready
document.addEventListener('DOMContentLoaded', function() {
    detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
});

function showDetailModal(bookingId) {
    console.log('Showing detail for booking ID:', bookingId);
    
    // Reset content dengan loading
    document.getElementById('detail-content').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat data booking...</p>
        </div>
    `;
    
    // Show modal
    detailModal.show();
    
    // Fetch data dengan proper headers
    fetch(`/bookings/${bookingId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response is not JSON. Server returned HTML instead.');
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Data received:', data);
        
        if (!data || !data.booking) {
            throw new Error('Invalid data format received');
        }
        
        displayBookingDetail(data.booking);
    })
    .catch(error => {
        console.error('Error:', error);
        showBookingError(error.message);
    });
}

function displayBookingDetail(booking) {
    console.log('Displaying booking:', booking);
    
    // Format data
    const kodeBooking = `BK${String(booking.id).padStart(3, '0')}`;
    const customerInfo = booking.user ? `${booking.user.name} (${booking.user.email})` : 'Tidak tersedia';
    const lapanganInfo = booking.lapangan ? booking.lapangan.nama : 'Tidak tersedia';
    const tanggalInfo = booking.tanggal ? (new Date(booking.tanggal)).toLocaleDateString('id-ID') : '-';
    const jamInfo = (booking.jam_mulai && booking.jam_selesai) ? 
        `${(new Date(`2000-01-01T${booking.jam_mulai}`)).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})} - ${(new Date(`2000-01-01T${booking.jam_selesai}`)).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}` : '-';
    const hargaInfo = booking.total_harga ? formatRupiah(booking.total_harga) : '-';
    
    // Status badges
    const statusBadge = getStatusBadgeHtml(booking.status);
    const paymentStatus = booking.payment ? 
        getStatusBadgeHtml(booking.payment.status) : 
        '<span class="badge bg-warning">Pending</span>';
    
    // Payment info
    const paymentMethod = booking.payment ? (booking.payment.metode_pembayaran || '-') : '-';
    const paymentAmount = booking.payment ? formatRupiah(booking.payment.jumlah) : '-';
    
    // Payment proof dengan image display
    let paymentProof = '-';
    if (booking.payment && booking.payment.bukti_pembayaran) {
        const proofUrl = `/storage/${booking.payment.bukti_pembayaran}`;
        console.log('Payment proof URL:', proofUrl);
        console.log('Payment proof filename:', booking.payment.bukti_pembayaran);
        
        const isImage = booking.payment.bukti_pembayaran.toLowerCase().match(/\.(jpg|jpeg|png|gif|webp)$/);
        console.log('Is image file:', isImage);
        
        if (isImage) {
            paymentProof = `
                <div class="mt-2">
                    <div class="position-relative d-inline-block">
                        <img src="${proofUrl}" 
                             alt="Bukti Pembayaran" 
                             class="img-thumbnail rounded shadow-sm payment-proof-image" 
                             style="max-width: 100%; max-height: 250px; cursor: pointer; transition: transform 0.2s;"
                             onclick="window.open('${proofUrl}', '_blank')"
                             onload="console.log('Payment proof image loaded successfully'); this.style.opacity='1';"
                             onerror="console.error('Payment proof image failed to load, URL:', '${proofUrl}'); this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iIzZjNzU3ZCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LXNpemU9IjE2IiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+SW1hZ2UgTm90IEZvdW5kPC90ZXh0Pjwvc3ZnPg=='; this.style.opacity='0.5';"
                             style="opacity: 0;">
                        <div class="position-absolute top-50 start-50 translate-middle" id="loading-${booking.payment.id}">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <small class="text-muted">
                        <i class="fas fa-search-plus me-1"></i>Klik gambar untuk memperbesar
                    </small>
                </div>
            `;
        } else {
            // For PDF or other files
            paymentProof = `
                <div class="mt-2">
                    <a href="${proofUrl}" 
                       target="_blank" 
                       class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-pdf me-1"></i>Lihat Bukti Pembayaran
                    </a>
                    <br>
                    <small class="text-muted">Buka di tab baru untuk melihat file</small>
                </div>
            `;
        }
    } else {
        console.log('No payment proof found');
        console.log('Payment data:', booking.payment);
        
        // Tampilkan pesan yang lebih informatif
        if (booking.payment) {
            paymentProof = '<span class="text-muted"><i class="fas fa-exclamation-circle me-1"></i>Belum ada bukti pembayaran</span>';
        } else {
            paymentProof = '<span class="text-muted"><i class="fas fa-info-circle me-1"></i>Payment data tidak tersedia</span>';
        }
    }
    
    // Build content dengan design yang lebih menarik
    const content = `
        <div class="row g-4">
            <!-- Booking Info Section -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title mb-4">
                            <i class="fas fa-calendar-check text-primary me-2"></i>Informasi Booking
                        </h6>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded p-2">
                                            <i class="fas fa-hashtag text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Kode Booking</h6>
                                        <p class="mb-0 fw-semibold">${kodeBooking}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-info bg-opacity-10 rounded p-2">
                                            <i class="fas fa-user text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Customer</h6>
                                        <p class="mb-0 fw-semibold">${customerInfo}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                            <i class="fas fa-map-marker-alt text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Lapangan</h6>
                                        <p class="mb-0 fw-semibold">${lapanganInfo}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-warning bg-opacity-10 rounded p-2">
                                            <i class="fas fa-calendar text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Tanggal</h6>
                                        <p class="mb-0 fw-semibold">${tanggalInfo}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-secondary bg-opacity-10 rounded p-2">
                                            <i class="fas fa-clock text-secondary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Jam</h6>
                                        <p class="mb-0 fw-semibold">${jamInfo}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                            <i class="fas fa-tag text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Total Harga</h6>
                                        <p class="mb-0 fw-semibold text-success">${hargaInfo}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded p-2">
                                            <i class="fas fa-info-circle text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Status</h6>
                                        <p class="mb-0 fw-semibold">${statusBadge}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Info Section -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title mb-4">
                            <i class="fas fa-credit-card text-success me-2"></i>Informasi Pembayaran
                        </h6>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-warning bg-opacity-10 rounded p-2">
                                            <i class="fas fa-credit-card text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Status Payment</h6>
                                        <p class="mb-0 fw-semibold">${paymentStatus}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-info bg-opacity-10 rounded p-2">
                                            <i class="fas fa-wallet text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Metode</h6>
                                        <p class="mb-0 fw-semibold">${paymentMethod}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Jumlah</h6>
                                        <p class="mb-0 fw-semibold text-success">${paymentAmount}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded p-2">
                                            <i class="fas fa-image text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Bukti Pembayaran</h6>
                                        <p class="mb-0 fw-semibold">${paymentProof}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        ${booking.catatan ? `
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-3">
                                <i class="fas fa-sticky-note text-warning me-2"></i>Catatan
                            </h6>
                            <p class="mb-0">${booking.catatan}</p>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detail-content').innerHTML = content;
    
    // Hide loading spinners after a short delay to allow images to load
    setTimeout(() => {
        const loadingSpinners = document.querySelectorAll('[id^="loading-"]');
        loadingSpinners.forEach(spinner => {
            spinner.style.display = 'none';
        });
    }, 500);
}

function showBookingError(message) {
    const content = `
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Tidak dapat memuat data booking.
            <br><small class="text-muted">${message}</small>
            <hr>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-warning btn-sm" onclick="location.reload()">
                    <i class="fas fa-redo me-1"></i> Refresh Halaman
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('detail-content').innerHTML = content;
}

function rejectBookingClient(id) {
    Swal.fire({
        title: 'Tolak Booking?',
        input: 'textarea',
        inputLabel: 'Alasan penolakan',
        inputPlaceholder: 'Masukkan alasan penolakan...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        preConfirm: (reason) => {
            if (!reason || reason.trim() === '') {
                Swal.showValidationMessage('Alasan penolakan harus diisi');
                return false;
            }
            return reason;
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/bookings/${id}/reject`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            
            const reasonField = document.createElement('input');
            reasonField.type = 'hidden';
            reasonField.name = 'reason';
            reasonField.value = result.value;
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(reasonField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function refreshData() {
    window.location.reload();
}

function searchBooking() {
    const searchTerm = document.getElementById('search-booking').value;
    const status = document.getElementById('filter-status').value;
    const tanggal = document.getElementById('filter-tanggal').value;
    const lapangan = document.getElementById('filter-lapangan').value;
    
    const params = new URLSearchParams();
    if (searchTerm) params.append('search', searchTerm);
    if (status) params.append('status', status);
    if (tanggal) params.append('tanggal', tanggal);
    if (lapangan) params.append('lapangan_id', lapangan);
    
    window.location.href = '{{ route("bookings.index") }}?' + params.toString();
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter-status').addEventListener('change', searchBooking);
    document.getElementById('filter-tanggal').addEventListener('change', searchBooking);
    document.getElementById('filter-lapangan').addEventListener('change', searchBooking);
});
</script>
@endsection

