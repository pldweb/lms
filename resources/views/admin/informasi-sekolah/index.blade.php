@extends('layouts.admin')
@section('title', 'Informasi Sekolah')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Informasi Sekolah</li>
            </ol>
        </nav>
        <h2 class="h4">Informasi Sekolah</h2>
        <p class="mb-0">Kelola informasi sekolah yang akan ditampilkan di website</p>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h5 mb-0">Informasi Sekolah</h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form id="informasiSekolahForm" action="/admin/informasi-sekolah/store" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $informasiSekolah->nama_sekolah ?? '') }}" placeholder="Masukkan nama sekolah" required>
                            @error('nama_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tagline" class="form-label">Tagline <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tagline') is-invalid @enderror" id="tagline" name="tagline" value="{{ old('tagline', $informasiSekolah->tagline ?? '') }}" placeholder="Masukkan tagline sekolah" required>
                            @error('tagline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap sekolah" required>{{ old('alamat', $informasiSekolah->alamat ?? '') }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $informasiSekolah->nomor_telepon ?? '') }}" placeholder="Contoh: 021-7654321" required>
                            @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nomor_handphone" class="form-label">Nomor Handphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_handphone') is-invalid @enderror" id="nomor_handphone" name="nomor_handphone" value="{{ old('nomor_handphone', $informasiSekolah->nomor_handphone ?? '') }}" placeholder="Contoh: 081234567890" required>
                            @error('nomor_handphone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $informasiSekolah->email ?? '') }}" placeholder="Contoh: info@sekolah.sch.id" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label">Latitude <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $informasiSekolah->latitude ?? '') }}" placeholder="Contoh: -6.2088" required>
                            @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label">Longitude <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $informasiSekolah->longitude ?? '') }}" placeholder="Contoh: 106.8456" required>
                            @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo Sekolah</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                        <small class="form-text text-muted">Upload logo baru jika ingin mengubah logo yang ada. Format: JPG, PNG, GIF, SVG. Maks: 2MB.</small>
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-gray-800 me-2">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ url('admin/dashboard') }}" class="btn btn-light">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow">
            <div class="card-header">
                <h2 class="h5 mb-0">Preview Logo</h2>
            </div>
            <div class="card-body text-center">
                <div id="logoPreview" class="mb-3">
                    @if(isset($informasiSekolah) && $informasiSekolah->logo)
                        <img src="{{ asset('img/' . $informasiSekolah->logo) }}" alt="Logo Sekolah" class="img-fluid" style="max-height: 150px;">
                    @else
                        <div class="text-muted">Belum ada logo</div>
                    @endif
                </div>
                <p class="text-muted">Logo akan ditampilkan di sini</p>
                <hr>
                <small class="text-muted">
                    <strong>Format yang didukung:</strong><br>
                    • JPG/JPEG<br>
                    • PNG<br>
                    • GIF<br>
                    • SVG<br>
                    <strong>Ukuran maksimal:</strong> 2MB
                </small>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Preview logo saat memilih file
document.getElementById('logo').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const logoPreview = document.getElementById('logoPreview');
            logoPreview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="img-fluid" style="max-height: 150px;">`;  
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush