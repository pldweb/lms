<style>
    .disabled {
        pointer-events: none;
        opacity: 0.5;
        background-color: #f5f5f5 !important;
        color: #888;
    }
</style>

<form id="slideshowForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
                    @csrf
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="title">Judul <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="title" name="title" value="{{ $data->title ?? '' }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-10 row">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <div class="col-12">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $data->deskripsi ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="link">Link</label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="link" name="link" value="{{ $data->link ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="tombol_text">Teks Tombol</label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="tombol_text" name="tombol_text" value="{{ $data->tombol_text ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="image">Gambar <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="file" class="form-control" id="image" name="image" {{ $data->image ?? '' ? '' : 'required' }}>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB.</small>
                            @if($data->image ?? '')
                                <div class="mt-2">
                                    <img src="{{ asset($data->image) }}" alt="Preview" style="max-width: 250px;" class="img-preview">
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="urutan">Urutan <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="number" class="form-control" id="urutan" name="urutan" value="{{ $data->urutan ?? '' }}" min="0" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label d-block">Status</label>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" {{ isset($data->aktif) && $data->aktif ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" class="form-control" name="id" value="{{ $data->id ?? '' }}">
                    <div class="mb-20 mt-20">
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-add">Simpan</button>
                    </div>
                </form>

<script>
    $(document).ready(function () {
        $('#slideshowForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/slideshow/store', formData, '#message-modal')
            });
        });
    });
</script>