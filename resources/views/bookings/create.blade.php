@extends('layouts.app')

@section('title', 'Buat Booking')

@section('content')
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-calendar-plus me-2"></i>Buat Booking Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="lapangan_id" class="form-label">Lapangan <span class="text-danger">*</span></label>
                    <select class="form-select @error('lapangan_id') is-invalid @enderror" id="lapangan_id" name="lapangan_id" required>
                        <option value="">Pilih Lapangan</option>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}" {{ old('lapangan_id') == $lapangan->id ? 'selected' : '' }}>
                                {{ $lapangan->nama }} - {{ formatRupiah($lapangan->harga_per_jam) }}/jam
                            </option>
                        @endforeach
                    </select>
                    @error('lapangan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" min="{{ date('Y-m-d') }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                    <select class="form-select @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" required>
                        <option value="">Pilih Jam</option>
                        @for($hour = 6; $hour <= 22; $hour++)
                            <option value="{{ sprintf('%02d:00', $hour) }}" {{ old('jam_mulai') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $hour) }}
                            </option>
                        @endfor
                    </select>
                    @error('jam_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                    <select class="form-select @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" required>
                        <option value="">Pilih Jam</option>
                        @for($hour = 7; $hour <= 23; $hour++)
                            <option value="{{ sprintf('%02d:00', $hour) }}" {{ old('jam_selesai') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $hour) }}
                            </option>
                        @endfor
                    </select>
                    @error('jam_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                <select class="form-select @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran" required onchange="togglePaymentProof()">
                    <option value="">Pilih Metode</option>
                    <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash (Bayar di Tempat)</option>
                    <option value="transfer_bank" {{ old('metode_pembayaran') == 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="ewallet" {{ old('metode_pembayaran') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
                @error('metode_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Bukti Pembayaran - Muncul hanya untuk transfer/ewallet -->
            <div class="mb-3" id="bukti_pembayaran_group" style="display: none;">
                <label for="bukti_pembayaran" class="form-label">
                    Bukti Pembayaran <span class="text-danger">*</span>
                    <small class="text-muted"> (Upload bukti transfer untuk metode transfer/e-wallet)</small>
                </label>
                <input type="file" 
                       class="form-control @error('bukti_pembayaran') is-invalid @enderror" 
                       id="bukti_pembayaran" 
                       name="bukti_pembayaran" 
                       accept="image/*,.pdf"
                       onchange="previewPaymentProof(this)">
                @error('bukti_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Format: JPG, PNG, atau PDF. Maksimal 2MB.</div>
                
                <!-- Preview Image -->
                <div id="payment_preview" class="mt-2" style="display: none;">
                    <img id="payment_preview_img" src="#" alt="Preview Bukti Pembayaran" class="img-thumbnail" style="max-height: 200px;">
                    <br>
                    <small class="text-muted">Preview bukti pembayaran</small>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan (Opsional)</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePaymentProof() {
    const metodePembayaran = document.getElementById('metode_pembayaran').value;
    const buktiGroup = document.getElementById('bukti_pembayaran_group');
    const buktiInput = document.getElementById('bukti_pembayaran');
    
    // Show/hide bukti pembayaran field
    if (metodePembayaran === 'transfer_bank' || metodePembayaran === 'ewallet') {
        buktiGroup.style.display = 'block';
        buktiInput.setAttribute('required', 'required');
    } else {
        buktiGroup.style.display = 'none';
        buktiInput.removeAttribute('required');
        // Clear preview
        document.getElementById('payment_preview').style.display = 'none';
        document.getElementById('payment_preview_img').src = '#';
    }
}

function previewPaymentProof(input) {
    const preview = document.getElementById('payment_preview');
    const previewImg = document.getElementById('payment_preview_img');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Check file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('File terlalu besar! Maksimal 2MB.');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Check file type
        if (!file.type.match('image.*') && file.type !== 'application/pdf') {
            alert('Format file tidak didukung! Gunakan JPG, PNG, atau PDF.');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            if (file.type === 'application/pdf') {
                // For PDF, show a placeholder or icon
                previewImg.src = 'https://via.placeholder.com/200x150/6c757d/ffffff?text=PDF+Document';
                previewImg.alt = 'PDF Document';
            } else {
                // For images, show the actual image
                previewImg.src = e.target.result;
                previewImg.alt = 'Preview Bukti Pembayaran';
            }
            preview.style.display = 'block';
        };
        
        reader.onerror = function() {
            alert('Gagal membaca file! Silakan coba lagi.');
            input.value = '';
            preview.style.display = 'none';
        };
        
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        previewImg.src = '#';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePaymentProof();
});
</script>
@endsection

