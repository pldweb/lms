<form id="createUserForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Nama</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputName" name="nama" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Email</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputEmail" name="email" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Ganti Password</label>
        <div class="col-12">
            <input type="password" class="form-control" id="inputPassword" name="password">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Role User</label>
        <div class="col-12">
            <select class="form-control" id="inputJenis" name="jenis">
                <option value="Admin">Admin</option>
                <option value="Guru">Guru</option>
                <option value="Siswa">Siswa</option>
                <option value="Wali Murid">Wali Murid</option>
            </select>
        </div>
    <div class="mb-20 mt-20">
        <button type="submit" id="btnChangePassword" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#createUserForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/user/create-user-action', formData, '#message-modal')
            });
        });
    });
</script>