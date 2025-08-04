<form id="changePasswordForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Ganti Password</label>
        <div class="col-12">
            <input type="password" class="form-control" id="inputPassword" name="password">
        </div>
    </div>
    <div class="mb-20 mt-20">
        <button type="submit" id="btnChangePassword" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#changePasswordForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/profile/change-password-action', formData, '#message-modal')
            });
        });
    });
</script>