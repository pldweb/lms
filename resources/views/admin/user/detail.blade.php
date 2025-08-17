<form id="detailUserForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Nama</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputName" name="nama" value="{{ $user->nama }}">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Email</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputEmail" name="email" value="{{ $user->email }}">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Ganti Password</label>
        <div class="col-12">
            <input type="password" class="form-control" id="inputPassword" name="password">
        </div>
    </div>
    <input type="hidden" id="inputId" name="id" value="{{ $user->id }}">
    <input type="hidden" id="inputJenis" name="jenis" value="{{ $jenis }}">
    <div class="mb-20 mt-20">
        <button type="submit" id="btnChangePassword" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#detailUserForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/user/update-user-action', formData, '#message-modal')
            });
        });
    });
</script>