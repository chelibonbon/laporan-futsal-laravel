@extends('layouts.app')

@section('title', Auth::user()->isCustomer() ? 'Cari Lapangan' : 'Kelola Lapangan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>
            <i class="fas fa-map me-2"></i>
            @if(Auth::user()->isCustomer())
                Cari Lapangan
            @else
                Kelola Lapangan
            @endif
        </h5>
        @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
            <div>
                <a href="{{ route('lapangans.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Lapangan
                </a>
            </div>
        @endif
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" action="{{ route('lapangans.index') }}" class="mb-3">
            <div class="row">
                @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                    <div class="col-md-3">
                        <select class="form-select" name="daerah">
                            <option value="">Semua Daerah</option>
                            @foreach($daerahList ?? [] as $d)
                                <option value="{{ $d }}" {{ request('daerah') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                @endif
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari lapangan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>

        @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
            <!-- Stats -->
            <div class="row mb-4">
                <div class="col">
                    <div class="card border border-primary shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="text-primary"><i class="fas fa-map me-2"></i>Total</h5>
                            <h3 class="mb-0 text-dark">{{ $totalLapangan ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border border-success shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="text-success"><i class="fas fa-check-circle me-2"></i>Aktif</h5>
                            <h3 class="mb-0 text-dark">{{ $activeLapangan ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border border-danger shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="text-danger"><i class="fas fa-times-circle me-2"></i>Tidak Aktif</h5>
                            <h3 class="mb-0 text-dark">{{ $inactiveLapangan ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border border-info shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="text-info"><i class="fas fa-chart-line me-2"></i>Rata-rata</h5>
                            <h3 class="mb-0 text-dark">{{ $avgPrice ? formatRupiah($avgPrice) : '-' }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border border-warning shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="text-warning"><i class="fas fa-star me-2"></i>Rating</h5>
                            <h3 class="mb-0 text-dark">4.5</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Lapangan Grid -->
        <div class="row">
            @forelse($lapangans as $lapangan)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if($lapangan->foto)
                            <img src="{{ asset('storage/' . $lapangan->foto) }}" class="card-img-top" alt="{{ $lapangan->nama }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ $lapangan->nama }}</h6>
                                <span class="badge bg-{{ $lapangan->status === 'aktif' ? 'success' : 'danger' }}">
                                    {{ $lapangan->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $lapangan->lokasi }}
                            </p>
                            <div class="mb-2">
                                <small class="text-muted">Fasilitas:</small><br>
                                @if($lapangan->fasilitas)
                                    @php
                                        $fasilitasArray = explode(',', $lapangan->fasilitas);
                                    @endphp
                                    @foreach(array_slice($fasilitasArray, 0, 3) as $fasilitas)
                                        <span class="badge bg-info me-1">{{ trim($fasilitas) }}</span>
                                    @endforeach
                                    @if(count($fasilitasArray) > 3)
                                        <span class="badge bg-secondary">+{{ count($fasilitasArray) - 3 }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>{{ $lapangan->kapasitas }} orang<br>
                                        <i class="fas fa-money-bill-wave me-1"></i>{{ formatRupiah($lapangan->harga_per_jam) }}/jam
                                    </small>
                                </div>
              
  <div class="btn-group btn-group-sm" role="group">

    <button type="button"
        class="btn btn-info"
        onclick="showDetail({{ $lapangan->id }})"
        title="Lihat Detail">
        <i class="fas fa-eye"></i>
    </button>

    @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())

        <a href="{{ route('lapangans.edit', $lapangan->id) }}"
           class="btn btn-warning"
           title="Edit">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit"
            form="toggle-{{ $lapangan->id }}"
            class="btn btn-{{ $lapangan->status === 'aktif' ? 'secondary' : 'success' }}"
            title="Ubah Status">
            <i class="fas fa-{{ $lapangan->status === 'aktif' ? 'ban' : 'check' }}"></i>
        </button>

        <button type="submit"
            form="delete-{{ $lapangan->id }}"
            class="btn btn-danger"
            title="Hapus">
            <i class="fas fa-trash"></i>
        </button>

    @elseif(Auth::user()->isCustomer() && $lapangan->status === 'aktif')

        <a href="{{ route('bookings.create') }}?lapangan_id={{ $lapangan->id }}"
           class="btn btn-primary"
           title="Booking">
            <i class="fas fa-calendar-plus"></i>
        </a>

    @endif
</div>

{{-- FORM DI LUAR BTN-GROUP --}}
<form id="toggle-{{ $lapangan->id }}"
      action="{{ route('lapangans.toggleStatus', $lapangan->id) }}"
      method="POST"
      onsubmit="return confirm('Ubah status lapangan ini?')">
    @csrf
</form>

<form id="delete-{{ $lapangan->id }}"
      action="{{ route('lapangans.destroy', $lapangan->id) }}"
      method="POST"
      onsubmit="return confirm('Hapus lapangan ini?')">
    @csrf
    @method('DELETE')
</form>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-map fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada lapangan</h5>
                    </div>
                </div>
            @endforelse
        </div>

        @if($lapangans->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $lapangans->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Lapangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail-content">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Global variable untuk modal
let detailModal = null;

// Initialize modal saat document ready
document.addEventListener('DOMContentLoaded', function() {
    detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
});

function showDetail(id) {
    console.log('Showing detail for ID:', id);
    
    // Reset content
    document.getElementById('detail-content').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat data...</p>
        </div>
    `;
    
    // Show modal
    detailModal.show();
    
    // Fetch data dengan proper headers
    fetch(`/lapangans/${id}`, {
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
        
        if (!data || !data.lapangan) {
            throw new Error('Invalid data format received');
        }
        
        displayLapanganDetail(data.lapangan);
    })
    .catch(error => {
        console.error('Error:', error);
        showError(error.message);
    });
}

function displayLapanganDetail(lapangan) {
    // Format image URL - fix path
    let fotoUrl = 'https://via.placeholder.com/400x250/6c757d/ffffff?text=No+Image';
    if (lapangan.foto) {
        // Remove 'lapangan/' prefix if exists and use correct path
        const filename = lapangan.foto.replace('lapangan\\', '').replace('lapangan/', '');
        fotoUrl = `/storage/lapangan/${filename}`;
        console.log('Image URL:', fotoUrl);
    }
    
    // Format fasilitas
    let fasilitas = '-';
    if (lapangan.fasilitas) {
        fasilitas = lapangan.fasilitas.split(',')
            .map(f => `<span class="badge bg-light text-dark me-1 border">${f.trim()}</span>`)
            .join('');
    }
    
    // Format harga
    const harga = formatRupiah(lapangan.harga_per_jam);
    
    // Status badge
    const statusBadge = lapangan.status === 'aktif' ? 
        '<span class="badge bg-success rounded-pill px-3 py-2"><i class="fas fa-check-circle me-1"></i>Aktif</span>' : 
        '<span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>';
    
    // Build content dengan design yang lebih menarik
    const content = `
        <div class="row g-4">
            <!-- Gambar Section -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm">
                    <img src="${fotoUrl}" 
                         class="card-img-top rounded-top" 
                         alt="${lapangan.nama}" 
                         style="height: 250px; object-fit: cover;"
                         onerror="console.log('Image failed to load, using fallback'); this.src='https://via.placeholder.com/400x250/6c757d/ffffff?text=No+Image';">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">${lapangan.nama}</h5>
                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>${lapangan.lokasi}
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            ${statusBadge}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detail Section -->
            <div class="col-md-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title mb-4">
                            <i class="fas fa-info-circle text-primary me-2"></i>Informasi Lapangan
                        </h6>
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded p-2">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Lokasi</h6>
                                        <p class="mb-0 fw-semibold">${lapangan.lokasi}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-info bg-opacity-10 rounded p-2">
                                            <i class="fas fa-globe text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Daerah</h6>
                                        <p class="mb-0 fw-semibold">${lapangan.daerah}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                            <i class="fas fa-users text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Kapasitas</h6>
                                        <p class="mb-0 fw-semibold">${lapangan.kapasitas} orang</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-warning bg-opacity-10 rounded p-2">
                                            <i class="fas fa-tag text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 small text-muted">Harga/Jam</h6>
                                        <p class="mb-0 fw-semibold text-success">${harga}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fasilitas Section -->
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-3">
                                <i class="fas fa-check-square text-success me-2"></i>Fasilitas
                            </h6>
                            <div class="d-flex flex-wrap gap-1">
                                ${fasilitas}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detail-content').innerHTML = content;
}

function showError(message) {
    const content = `
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Tidak dapat memuat data lapangan.
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

function formatRupiah(amount) {
    return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
}
</script>

