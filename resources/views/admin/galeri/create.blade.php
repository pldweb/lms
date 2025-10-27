@extends('layouts.admin')
@section('title', isset($galeri) ? 'Edit Item Galeri' : 'Tambah Item Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ isset($galeri) ? 'Edit Item Galeri' : 'Tambah Item Galeri' }}</h3>
                    <a href="{{ url('/admin/galeri') }}" class="btn btn-secondary btn-add">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="galeriForm" enctype="multipart/form-data">
                    @csrf
                    @if(isset($galeri))
                        <input type="hidden" name="id" value="{{ $galeri->id }}">
                    @endif
                    <input type="hidden" name="tipe" value="foto">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori_galeri_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <input type="hidden" name="kategori_galeri_id" value="{{ $kategori_terpilih->id }}">
                                <div class="form-control bg-light">{{ $kategori_terpilih->nama_kategori }}</div>
                                <small class="text-muted">{{ $kategori_terpilih->deskripsi }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ isset($galeri) ? $galeri->judul : '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ isset($galeri) ? $galeri->deskripsi : '' }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_foto" class="form-label">Tanggal Foto</label>
                                        <input type="date" class="form-control" id="tanggal_foto" name="tanggal_foto" value="{{ isset($galeri) && $galeri->tanggal_foto ? $galeri->tanggal_foto->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select select2" id="status" name="status" required>
                                            <option value="aktif" {{ isset($galeri) && $galeri->status == 'aktif' ? 'selected' : (!isset($galeri) ? 'selected' : '') }}>Aktif</option>
                                            <option value="nonaktif" {{ isset($galeri) && $galeri->status == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if(isset($galeri))
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach (\App\Models\Galeri::where('kategori_galeri_id', $galeri->kategori_galeri_id)->get() as $index => $item)
                                            <div class="existing-image-container position-relative" data-galeri-id="{{ $item->id }}">
                                                <img src="{{ asset('img/uploads/' . $item->file_path) }}" alt="{{ $item->judul }}" class="existing-image img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" data-item-id="{{ $item->id }}">
                                                
                                                <!-- Overlay untuk menandai yang sedang diedit -->
                                                <div class="edit-overlay position-absolute top-0 start-0 w-100 h-100 d-none">
                                                    <div class="bg-primary bg-opacity-75 w-100 h-100 d-flex align-items-center justify-content-center rounded">
                                                        <i class="ph ph-pencil text-white" style="font-size: 24px;"></i>
                                                    </div>
                                                </div>
                                                
                                                <!-- Tombol aksi -->
                                                <div class="image-actions position-absolute" style="top: -8px; right: -8px;">
                                                    <div class="btn-group-vertical">
                                                        <button type="button" class="btn btn-sm btn-warning btn-edit-image" data-item-id="{{ $item->id }}" title="Ganti gambar ini">
                                                            <i class="ph ph-pencil" style="font-size: 10px;"></i>
                                                        </button>
                                                        @if($index > 0)
                                                            <button type="button" class="btn btn-sm btn-danger btn-delete-image" data-item-id="{{ $item->id }}" title="Hapus gambar ini">
                                                                <i class="ph ph-trash" style="font-size: 10px;"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Info gambar -->
                                                <div class="image-info position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white p-1" style="font-size: 10px;">
                                                    {{ Str::limit($item->judul, 15) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">
                                    {{ isset($galeri) ? 'Pilih/Ganti Foto' : 'Pilih Foto' }} 
                                    <span class="text-danger">{{ !isset($galeri) ? '*' : '' }}</span>
                                </label>
                                
                                <div class="d-flex gap-2 mb-2">
                                    <button type="button" id="btnOpenFileManager" class="btn btn-primary">
                                        <i class="ph ph-folder-open"></i> <span id="btnText">Pilih dari File Manager</span>
                                    </button>
                                    <button type="button" id="btnClearSelection" class="btn btn-outline-secondary" style="display: none;">
                                        <i class="ph ph-x"></i> Clear
                                    </button>
                                    <button type="button" id="btnCancelEdit" class="btn btn-outline-warning" style="display: none;">
                                        <i class="ph ph-x-circle"></i> Batal Edit
                                    </button>
                                </div>
                                
                                <!-- Hidden inputs -->
                                <input type="hidden" name="selected_images" id="selectedImages" {{ !isset($galeri) ? 'required' : '' }}>
                                <input type="hidden" name="edit_mode" id="editMode" value="">
                                <input type="hidden" name="edit_item_id" id="editItemId" value="">
                                
                                <div id="selectedImagesPreview" class="d-flex flex-wrap gap-2 mb-2"></div>
                                
                                <small class="text-muted">
                                    <span id="helpText">Klik "Pilih dari File Manager" untuk memilih gambar yang sudah ada atau upload gambar baru.</span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" onclick="submitForm('nonaktif')">
                            <i class="ph ph-floppy-disk"></i> {{ isset($galeri) ? 'Update sebagai Non-Aktif' : 'Simpan sebagai Non-Aktif' }}
                        </button>
                        <button type="button" class="btn btn-primary" onclick="submitForm('aktif')">
                            <i class="ph ph-check"></i> {{ isset($galeri) ? 'Update & Aktifkan' : 'Simpan & Aktifkan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include File Manager Component -->
@include('admin.components.file-manager')

<style>
.selected-image {
    position: relative;
    display: inline-block;
}

.selected-image img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

.remove-selected {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 20px;
    height: 20px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Existing image styles */
.existing-image-container {
    cursor: pointer;
    transition: all 0.3s ease;
}

.existing-image-container:hover {
    transform: scale(1.05);
}

.existing-image-container.editing {
    border: 3px solid #0d6efd;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
}

.existing-image-container.editing .edit-overlay {
    display: block !important;
}

.image-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.existing-image-container:hover .image-actions {
    opacity: 1;
}

.image-actions .btn {
    width: 20px;
    height: 20px;
    padding: 0;
    margin-bottom: 2px;
    border-radius: 50%;
}

.image-info {
    border-radius: 0 0 4px 4px;
    text-align: center;
}

/* Edit mode highlights */
.edit-mode-active {
    background-color: rgba(255, 193, 7, 0.1);
    border: 2px dashed #ffc107;
    border-radius: 8px;
    padding: 10px;
}

.edit-mode-text {
    color: #856404;
    font-weight: 600;
}
</style>

<script>
// Global variables untuk menyimpan gambar yang dipilih
let selectedImages = [];
let editMode = false;
let editingItemId = null;

$(document).ready(function() {
    initSelect2(".select2");
    
    // Event handler untuk tombol edit gambar individual
    $(document).on('click', '.btn-edit-image', function() {
        const itemId = $(this).data('item-id');
        enterEditMode(itemId);
    });
    
    // Event handler untuk tombol hapus gambar individual
    $(document).on('click', '.btn-delete-image', function() {
        const itemId = $(this).data('item-id');
        if (confirm('Yakin ingin menghapus gambar ini?')) {
            deleteIndividualImage(itemId);
        }
    });
    
    // Event handler untuk buka file manager
    $('#btnOpenFileManager').on('click', function() {
        const isEditMode = editMode;
        const callback = isEditMode ? handleEditModeSelection : handleNormalSelection;
        
        fileManager.open({
            multiSelect: !isEditMode, // Single select untuk edit mode
            callback: callback
        });
    });
    
    // Event handler untuk batal edit
    $('#btnCancelEdit').on('click', function() {
        exitEditMode();
    });
    
    // Event handler untuk clear selection
    $('#btnClearSelection').on('click', function() {
        if (editMode) {
            exitEditMode();
        } else {
            selectedImages = [];
            updateSelectedImagesPreview();
            updateSelectedImagesInput();
        }
    });
});

// Masuk ke mode edit gambar individual
function enterEditMode(itemId) {
    editMode = true;
    editingItemId = itemId;
    
    // Update UI
    $('.existing-image-container').removeClass('editing');
    $(`.existing-image-container[data-galeri-id="${itemId}"]`).addClass('editing');
    
    // Update button text dan visibility
    $('#btnText').text('Pilih Gambar Pengganti');
    $('#btnCancelEdit').show();
    $('#helpText').html('<span class="edit-mode-text">🔄 Mode Edit: Pilih gambar pengganti untuk item yang dipilih</span>');
    
    // Set hidden inputs
    $('#editMode').val('replace');
    $('#editItemId').val(itemId);
    
    // Add edit mode styling ke container
    $('.existing-image-container').parent().addClass('edit-mode-active');
}

// Keluar dari mode edit
function exitEditMode() {
    editMode = false;
    editingItemId = null;
    
    // Reset UI
    $('.existing-image-container').removeClass('editing');
    $('.existing-image-container').parent().removeClass('edit-mode-active');
    
    // Reset button text dan visibility
    $('#btnText').text('Pilih dari File Manager');
    $('#btnCancelEdit').hide();
    $('#helpText').text('Klik "Pilih dari File Manager" untuk memilih gambar yang sudah ada atau upload gambar baru.');
    
    // Clear hidden inputs
    $('#editMode').val('');
    $('#editItemId').val('');
}

// Handle selection untuk mode normal (tambah gambar baru)
function handleNormalSelection(files) {
    selectedImages = files;
    updateSelectedImagesPreview();
    updateSelectedImagesInput();
}

// Handle selection untuk mode edit (ganti gambar)
function handleEditModeSelection(files) {
    if (files.length > 0) {
        const newImage = files[0]; // Ambil gambar pertama saja
        
        // Update preview gambar yang sedang diedit
        const editingContainer = $(`.existing-image-container[data-galeri-id="${editingItemId}"]`);
        editingContainer.find('.existing-image').attr('src', newImage.url);
        
        // Set data untuk submit
        selectedImages = [newImage];
        updateSelectedImagesInput();
        
        // Keluar dari mode edit
        exitEditMode();
        
        // Show success feedback
        showTempMessage('Gambar berhasil diganti! Jangan lupa klik Simpan.');
    }
}

// Hapus gambar individual
function deleteIndividualImage(itemId) {
    // AJAX call ke backend untuk hapus gambar
    $.ajax({
        url: '{{ url("/admin/galeri/delete-image") }}/' + itemId,
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Remove dari DOM
                $(`.existing-image-container[data-galeri-id="${itemId}"]`).fadeOut(300, function() {
                    $(this).remove();
                });
                showTempMessage('Gambar berhasil dihapus!');
            } else {
                alert('Gagal menghapus gambar: ' + response.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menghapus gambar');
        }
    });
}

// Show temporary message
function showTempMessage(message) {
    const alertHtml = `
        <div class="alert alert-success alert-dismissible fade show temp-alert" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert message
    $('.card-body').prepend(alertHtml);
    
    // Auto remove after 3 seconds
    setTimeout(function() {
        $('.temp-alert').fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

// Update preview gambar yang dipilih
function updateSelectedImagesPreview() {
    const preview = $('#selectedImagesPreview');
    const clearBtn = $('#btnClearSelection');
    
    preview.empty();
    
    if (selectedImages.length > 0 && !editMode) {
        clearBtn.show();
        
        selectedImages.forEach((image, index) => {
            const imageHtml = `
                <div class="selected-image" data-index="${index}">
                    <img src="${image.url}" alt="${image.name}" class="img-thumbnail" title="${image.name}">
                    <button type="button" class="remove-selected" onclick="removeSelectedImage(${index})">&times;</button>
                </div>
            `;
            preview.append(imageHtml);
        });
    } else if (!editMode) {
        clearBtn.hide();
    }
}

// Update hidden input untuk form submission
function updateSelectedImagesInput() {
    const imagePaths = selectedImages.map(img => {
        // Extract path from URL untuk disimpan ke database
        return img.url.replace(window.location.origin + '/img/uploads/', '');
    });
    $('#selectedImages').val(JSON.stringify(imagePaths));
}

// Hapus gambar dari selection
function removeSelectedImage(index) {
    selectedImages.splice(index, 1);
    updateSelectedImagesPreview();
    updateSelectedImagesInput();
}

// Submit form dengan handling untuk edit mode
function submitForm(status) {
    if (!validateForm()) return;
    
    $('#status').val(status);
    const formData = new FormData($('#galeriForm')[0]);
    
    const isUpdate = {{ isset($galeri) ? 'true' : 'false' }};
    const url = '{{ url("/admin/galeri/galeri-save") }}';
    
    let confirmMessage;
    if (editMode) {
        confirmMessage = 'Apakah Anda yakin ingin mengganti gambar yang dipilih?';
    } else if (isUpdate) {
        confirmMessage = `Apakah Anda yakin ingin ${status === 'aktif' ? 'mengupdate dan mengaktifkan' : 'mengupdate sebagai non-aktif'} item galeri ini?`;
    } else {
        confirmMessage = `Apakah Anda yakin ingin ${status === 'aktif' ? 'menyimpan dan mengaktifkan' : 'menyimpan sebagai non-aktif'} item galeri ini?`;
    }
    
    confirmModal(confirmMessage, function() {
        ajxProcess(url, formData, '#message-modal');
    });
}

// Form validation dengan handling edit mode
function validateForm() {
    if (!$('#kategori_galeri_id').val()) {
        alert('Silakan pilih kategori galeri');
        return false;
    }
    
    if (!$('#judul').val()) {
        alert('Silakan isi judul galeri');
        return false;
    }
    
    const isUpdate = {{ isset($galeri) ? 'true' : 'false' }};
    const hasExistingImages = $('.existing-image-container').length > 0;
    
    // Validasi berbeda untuk mode edit
    if (editMode) {
        if (selectedImages.length === 0) {
            alert('Silakan pilih gambar pengganti');
            return false;
        }
    } else if (!isUpdate && selectedImages.length === 0) {
        alert('Silakan pilih minimal satu foto');
        return false;
    } else if (isUpdate && selectedImages.length === 0 && !hasExistingImages) {
        alert('Silakan pilih minimal satu foto');
        return false;
    }
    
    return true;
}
</script>

@endsection
