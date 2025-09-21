<style>
    .disabled {
        pointer-events: none;
        opacity: 0.5;
        background-color: #f5f5f5 !important;
        color: #888;
    }
</style>

<form id="socialMediaForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group mb-10 row">
        <label class="form-label" for="title">Nama Media Sosial<span class="text-danger">*</span></label>
        <div class="col-12">
            <input type="text" class="form-control" id="title" name="nama" value="{{ $socialMedia->nama ?? '' }}" required>
        </div>
    </div>

    <div class="form-group mb-10 row">
        <label class="form-label" for="icon">Icon</label>
        <div class="col-12">
            <input type="file" class="form-control" id="icon" name="icon">
            <small class="text-muted">Contoh: icon instagram</small>
            <div id="iconPreview" class="mt-2">
                @if($socialMedia->icon)
                    <img src="{{ Storage::url($socialMedia->icon ?? '') }}" alt="Preview Icon" class="img-thumbnail" style="max-width: 100px;">
                @endif
            </div>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label" for="url">URL <span class="text-danger">*</span></label>
        <div class="col-12">
            <input type="text" class="form-control" id="url" name="link" value="{{ $socialMedia->link ?? '' }}" required>
            <small class="text-muted">Contoh: https://www.instagram.com/smpn20.jakarta</small>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label" for="urutan">Urutan <span class="text-danger">*</span></label>
        <div class="col-12">
            <input type="number" class="form-control" id="urutan" name="urutan" value="{{ $socialMedia->urutan ?? '' }}" min="0" required>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label d-block">Status</label>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" {{ isset($socialMedia->aktif) && $socialMedia->aktif ? 'checked' : '' }}>
                <label class="form-check-label" for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    
    <input type="hidden" class="form-control" name="id" value="{{ $socialMedia->id ?? '' }}">
    <div class="mb-20 mt-20">
        <button type="submit" id="btnSubmit" class="btn btn-primary btn-add">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#socialMediaForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/social-media/store', formData, '#message-modal')
            });
        });
    });
    
    $('#icon').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#iconPreview').html(`<img src="${e.target.result}" alt="Preview Icon" class="img-thumbnail" style="max-width: 100px;">`);
            }
            reader.readAsDataURL(file);
        }
    });
</script>