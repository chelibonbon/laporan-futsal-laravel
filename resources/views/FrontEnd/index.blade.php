@extends('FrontEnd.layout.headfoot')

@section('content')

@php
    $user = auth()->user();
    $userLevel = $user->level ?? null;

      $isInstructor = false;
    if ($userLevel == 2 && auth()->user()->guru) {
        $isInstructor = \App\Models\Ekskul::where(
            'instruktur_id',
            auth()->user()->guru->id
        )->exists();
    }
@endphp

<div class="instagram-reels-creator">
  <div class="container">
    <div class="cards-wrapper">

      {{-- ================= CARD 1 : WELCOME ================= --}}
      <div class="card mobile-card">
        <div class="card-content">
          <div class="image-container">
            <img
              src="https://images.pexels.com/photos/32471377/pexels-photo-32471377.jpeg"
              alt="Ekskul"
              class="background-image"
            >
          </div>

          <div class="text-overlay">
            <h2 class="main-title">WELCOME</h2>
            @if($userLevel == 3)
              <h3 class="subtitle">APP monitoring ekskul</h3>
              <p class="description">
                Lihat jadwal ekstrakurikuler yang tersedia untuk Anda ikuti.
              </p>
            @elseif($userLevel == 2)
              @php
                $guru = auth()->user()->guru;
                $isInstruktur = $guru && $guru->instrukturEkskuls()->exists();
              @endphp
              @if($isInstruktur)
                <h3 class="subtitle">Jadwal Ekskul</h3>
                <p class="description">
                  Kelola jadwal ekstrakurikuler yang Anda instruksikan.
                </p>
              @else
                <h3 class="subtitle">Absensi Siswa</h3>
                <p class="description">
                  Pantau absensi siswa berdasarkan rombel yang Anda walikan.
                </p>
              @endif
            @else
              <h3 class="subtitle">Monitoring Ekskul</h3>
              <p class="description">
                Pantau kegiatan ekstrakurikuler, absensi, dan nilai siswa dengan mudah.
              </p>
            @endif
          </div>

     
        </div>
      </div>

      {{-- ================= CARD 2 : KHUSUS ADMIN / GURU ================= --}}
      @if(in_array($userLevel, [1,2,5]))
      <div class="card aset-desa-card">
        <div class="card-header">
          <div class="status-indicator"></div>
          <span class="header-text">Monitoring Overview</span>
        </div>

        <div class="card-content">
          <div class="stats-container">
            <div class="stats-header">
              <h2 class="main-title">EKSTRAKURIKULER</h2>
              <p class="description">Ringkasan Kegiatan Ekskul</p>
            </div>

            <div class="stats-grid">
              <div class="stat-item">
                <div class="stat-value">📘</div>
                <div class="stat-label">Data Ekskul</div>
              </div>
              <div class="stat-item">
                <div class="stat-value">📅</div>
                <div class="stat-label">Jadwal Ekskul</div>
              </div>
              <div class="stat-item">
                <div class="stat-value">🧑‍🎓</div>
                <div class="stat-label">Absensi</div>
              </div>
              <div class="stat-item">
                <div class="stat-value">📊</div>
                <div class="stat-label">Nilai</div>
              </div>
            </div>


          </div>
        </div>
      </div>
      @endif

      {{-- ================= CARD 3 : KHUSUS SISWA ================= --}}
      @if($userLevel == 3)
      <div class="card siswa-card">
        <div class="card-header">
          <div class="status-indicator"></div>
          <span class="header-text">Pendaftaran Ekskul</span>
        </div>

        <div class="card-content">
          <div class="siswa-container">
            <div class="siswa-header">
              <h2 class="main-title">DAFTAR EKSKUL</h2>
              <p class="description">Ajukan pendaftaran ekstrakurikuler</p>
              @php
                $siswa = auth()->user()->siswa;
                $currentRegistrations = $siswa ? $siswa->daftar()->count() : 0;
                $maxRegistrations = 4;
              @endphp
              <p class="registration-status">Pendaftaran: {{ $currentRegistrations }} / {{ $maxRegistrations }}</p>
            </div>

            <div class="siswa-actions">
              @if($currentRegistrations >= $maxRegistrations)
                <button class="btn btn-secondary" disabled>Batas Maksimal Tercapai</button>
              @else
                <a href="{{ route('daftar.ekskul') }}" class="btn btn-primary">Daftar Ekskul</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endif

      {{-- ================= CARD 4 : KHUSUS GURU ================= --}}
      @if($userLevel == 2 && $isInstructor)
      <div class="card guru-card">
        <div class="card-header">
          <div class="status-indicator"></div>
          <span class="header-text">Kelola Ekskul</span>
        </div>

        <div class="card-content">
          <div class="guru-container">
            <div class="guru-header">
              <h2 class="main-title">KELOLA EKSKUL</h2>
              <p class="description">Kelola pendaftaran dan absensi siswa untuk ekskul yang Anda instruksikan</p>
              @php
                $guru = auth()->user()->guru;
                $pendingCount = 0;
                if ($guru) {
                  $pendingCount = \App\Models\Daftar::where('status', 'pending')
                    ->whereHas('ekskul', function ($q) use ($guru) {
                      $q->where('instruktur_id', $guru->id);
                    })->count();
                }
              @endphp
              <p class="pending-status">Pending: {{ $pendingCount }}</p>
            </div>

            <div class="guru-actions">
              <a href="{{ route('daftar.manage') }}" class="btn btn-primary me-2">Kelola Pendaftaran</a>
              <a href="{{ route('absensi.index') }}" class="btn btn-success">Kelola Absensi</a>
            </div>
          </div>
        </div>
      </div>
      @endif

      {{-- ================= CARD 5 : KHUSUS SISWA ================= --}}
      @if($userLevel == 3)
      <div class="card siswa-absensi-card">
        <div class="card-header">
          <div class="status-indicator"></div>
          <span class="header-text">Nilai & Absensi</span>
        </div>

        <div class="card-content">
          <div class="siswa-absensi-container">
            <div class="siswa-absensi-header">
              <h2 class="main-title">NILAI & ABSENSI</h2>
              <p class="description">Lihat nilai dan absensi ekskul yang Anda ikuti</p>
            </div>

            <div class="siswa-absensi-actions">
              <a href="{{ route('absensi.my') }}" class="btn btn-info">Lihat Nilai</a>
            </div>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
.instagram-reels-creator {
  min-height: calc(100vh - 200px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.cards-wrapper {
  display: flex;
  gap: 40px;
  justify-content: center;
  flex-wrap: wrap;
}

.card {
  border-radius: 25px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  transition: transform .3s ease;
}

.card:hover {
  transform: translateY(-5px);
}

/* MOBILE CARD */
.mobile-card {
  width: 380px;
  height: 550px;
  position: relative;
  background: #fff;
}

.image-container {
  height: 100%;
}

.background-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.text-overlay {
  position: absolute;
  top: 30px;
  left: 25px;
  right: 25px;
  color: white;
}

.main-title {
  font-size: 36px;
  font-weight: 700;
}

.subtitle {
  font-size: 26px;
  font-style: italic;
}

.description {
  font-size: 15px;
}

.generate-btn {
  position: absolute;
  bottom: 30px;
  left: 25px;
  right: 25px;
  padding: 16px;
  border-radius: 25px;
  border: none;
  background: linear-gradient(135deg,#6F8EEB,#77B6DF);
  color: white;
  font-weight: 600;
}

/* STATS CARD */
.aset-desa-card {
  width: 500px;
  background: white;
}

/* SISWA CARD */
.siswa-card {
  width: 400px;
  background: white;
}

.card-header {
  padding: 15px 25px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.status-indicator {
  width: 8px;
  height: 8px;
  background: #4ade80;
  border-radius: 50%;
}

.card-content {
  padding: 25px;
}

.stats-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.stat-item {
  padding: 20px;
  border-radius: 15px;
  background: #f4f6fb;
  text-align: center;
}

.stat-value {
  font-size: 28px;
}

.view-details-btn {
  width: 100%;
  margin-top: 25px;
  padding: 15px;
  border-radius: 25px;
  border: none;
  background: #667eea;
  color: white;
  font-weight: 600;
}
</style>

@endsection
