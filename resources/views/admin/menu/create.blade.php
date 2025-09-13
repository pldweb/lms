<style>
    .disabled {
        pointer-events: none;
        opacity: 0.5;
        background-color: #f5f5f5 !important;
        color: #888;
    }
</style>

<form id="menuForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group mb-10 row">
        <label class="form-label" for="title">Judul Menu <span class="text-danger">*</span></label>
        <div class="col-12">
            <input type="text" class="form-control" id="title" name="title" value="{{ $menu->title ?? '' }}" required>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label" for="url">URL <span class="text-danger">*</span></label>
        <div class="col-12">
            <input type="text" class="form-control" id="url" name="url" value="{{ $menu->url ?? '' }}" required>
            <small class="text-muted">Contoh: /berita, /kontak, /tentang-kami</small>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label" for="parent_id">Parent Menu</label>
        <div class="col-12">
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">-- Pilih Parent Menu --</option>
                @foreach($parentMenus as $parent)
                <option value="{{ $parent->id }}" {{ isset($menu->parent_id) && $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label" for="order">Urutan <span class="text-danger">*</span></label>
        <div class="col-12">
            <input type="number" class="form-control" id="order" name="order" value="{{ $menu->order ?? '' }}" min="0" required>
        </div>
    </div>
    
    <div class="form-group mb-10 row">
        <label class="form-label d-block">Status</label>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ isset($menu->active) && $menu->active ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Aktif</label>
            </div>
        </div>
    </div>
    
    <input type="hidden" class="form-control" name="id" value="{{ $menu->id ?? '' }}">
    <div class="mb-20 mt-20">
        <button type="submit" id="btnUpdate" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#menuForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/menu/store', formData, '#message-modal')
            });
        });
    });
</script>