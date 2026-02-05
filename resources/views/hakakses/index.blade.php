@extends('layouts.app')

@section('title', 'Hak Akses Menu')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i>
                        Hak Akses Menu
                    </h5>
                    <small class="text-muted">Kelola hak akses menu untuk setiap role</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('hakakses.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle" style="width: 250px;">Menu</th>
                                        <th class="text-center align-middle">Super Admin</th>
                                        <th class="text-center align-middle">Admin</th>
                                        <th class="text-center align-middle">Manager</th>
                                        <th class="text-center align-middle">Customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($menus as $menu)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($menu->icon)
                                                        <i class="{{ $menu->icon }} me-2"></i>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $menu->menu_name }}</strong>
                                                        @if($menu->description)
                                                            <br><small class="text-muted">{{ $menu->description }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            @foreach($roles as $role)
                                                <td class="text-center align-middle">
                                                    <div class="form-check form-check-primary d-flex justify-content-center">
                                                        <input type="hidden" name="access[{{ $menu->menu_key }}][{{ $role }}]" value="0">
                                                        <input type="checkbox" 
                                                               class="form-check-input" 
                                                               name="access[{{ $menu->menu_key }}][{{ $role }}]" 
                                                               value="1"
                                                               {{ $accessData[$role][$menu->menu_key] ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Belum ada menu yang tersedia
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Centang checkbox untuk memberikan akses menu pada role tertentu
                                </small>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-check-input:checked {
        background-color: #696cff;
        border-color: #696cff;
    }
    
    .table th {
        font-weight: 600;
        background-color: #f8f9fa !important;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endpush
