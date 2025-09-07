<style>
    .disabled {
        pointer-events: none;
        opacity: 0.5;
        background-color: #f5f5f5 !important;
    }
</style>

<form id="kategori" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Nama</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputName" name="nama" value="{{$data->nama ?? ''}}">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Slug</label>
        <div class="col-12">
            <input type="text" class="form-control disabled" id="inputSlug" disabled name="slug" value="{{$data->slug ?? ''}}">
        </div>
    </div>
    <input type="hidden" class="form-control" name="id" value="{{$data->id ?? ''}}">
    <div class="mb-20 mt-20">
        <button type="submit" id="btnUpdate" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#kategori').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/kategori-artikel/store', formData, '#message-modal')
            });
        });
    });
</script>