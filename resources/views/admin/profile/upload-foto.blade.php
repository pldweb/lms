<form id="uploadFotoProfile" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Pilih Foto Profile</label>
        <div class="col-12">
            <input type="file" class="form-control custom-file-input" id="foto_profile" accept="image/*" name="foto_profile">
        </div>
    </div>
    <div class="mb-20 mt-20">
        <button type="submit" id="btnUpload" class="btn btn-primary">Upload</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#uploadFotoProfile').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/profile/upload-foto-action', formData, '#message-modal')
            });
        });
    });
</script>