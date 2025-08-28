@extends('layouts.admin')
@section('title', 'Screenshot')
@section('content')
<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h5 mb-0">Informasi Screenshot</h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="socialMediaForm">
                    @csrf
                    @if($socialMedia)
                        <input type="hidden" name="id" value="{{ $socialMedia->id }}">
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Platform <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                   value="{{ $socialMedia->nama ?? old('nama') }}" 
                                   placeholder="Contoh: Facebook, Instagram, Twitter" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">Icon Class <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="icon" name="icon" 
                                   value="{{ $socialMedia->icon ?? old('icon') }}" 
                                   placeholder="Contoh: fab fa-facebook-f" required>
                            <small class="form-text text-muted">Gunakan Font Awesome icon class</small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="link" class="form-label">Link URL <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="link" name="link" 
                               value="{{ $socialMedia->link ?? old('link') }}" 
                               placeholder="https://facebook.com/username" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Deskripsi singkat tentang social media ini">{{ $socialMedia->deskripsi ?? old('deskripsi') }}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="urutan" class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="urutan" name="urutan" 
                                   value="{{ $socialMedia->urutan ?? old('urutan', 0) }}" 
                                   min="0" required>
                            <small class="form-text text-muted">Semakin kecil angka, semakin awal ditampilkan</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" 
                                       {{ ($socialMedia && $socialMedia->aktif) || (!$socialMedia) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif">
                                    Status Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-gray-800 me-2">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $socialMedia ? 'Update' : 'Simpan' }}
                        </button>
                        <a href="{{ route('admin.social_media') }}" class="btn btn-light">
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
                <h2 class="h5 mb-0">Preview Icon</h2>
            </div>
            <div class="card-body text-center">
                <div id="iconPreview" class="mb-3">
                    <i id="previewIcon" class="{{ $socialMedia->icon ?? 'fas fa-question' }} fa-3x text-primary"></i>
                </div>
                <p class="text-muted">Icon akan muncul di sini</p>
                <hr>
                <small class="text-muted">
                    <strong>Contoh icon class:</strong><br>
                    • fab fa-facebook-f<br>
                    • fab fa-instagram<br>
                    • fab fa-twitter<br>
                    • fab fa-youtube<br>
                    • fab fa-linkedin-in<br>
                    • fab fa-tiktok
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview icon saat mengetik
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value || 'fas fa-question';
    document.getElementById('previewIcon').className = iconClass + ' fa-3x text-primary';
});

// Submit form
document.getElementById('socialMediaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Disable button dan ubah text
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';
    
    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
    fetch('{{ route('admin.social_media.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } else {
            if (data.errors) {
                // Show validation errors
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    const feedback = input.parentNode.querySelector('.invalid-feedback');
                    if (input && feedback) {
                        input.classList.add('is-invalid');
                        feedback.textContent = data.errors[field][0];
                    }
                });
            } else {
                alert('Error: ' + data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data');
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endpush