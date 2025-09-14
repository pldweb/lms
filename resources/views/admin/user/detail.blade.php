<form id="detailUserForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    @csrf
    <div class="form-group">
        <label class="form-label" style="display: block;" for="nama">Nama</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputName" name="nama" value="{{ $user->nama }}">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="email">Email</label>
        <div class="col-12">
            <input type="text" class="form-control" id="inputEmail" name="email" value="{{ $user->email }}">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="password">Ganti Password</label>
        <div class="col-12">
            <input type="password" class="form-control" id="inputPassword" name="password">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="tanggal_lahir">Tanggal Lahir</label>
        <div class="col-12">
            <input type="date" class="form-control" id="inputTanggalLahir" name="tanggal_lahir" value="{{ $user->tanggal_lahir ? date('Y-m-d', strtotime($user->tanggal_lahir)) : '' }}">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" style="display: block;" for="foto_profile">Foto Profile</label>
        <div class="col-12 mb-2">
            <input type="file" class="form-control" id="inputFoto" name="foto_profile" accept="image/*">
            <small class="form-text text-muted">Upload foto profile dengan format JPG, PNG, atau JPEG.</small>
        </div>
        <div class="col-12">
            <img id="previewFoto" src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : asset('admin/images/thumbs/avatar.png') }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;" alt="Preview Foto">
        </div>
    </div>
    <input type="hidden" id="inputId" name="id" value="{{ $user->id }}">
    <input type="hidden" id="inputJenis" name="jenis" value="{{ $jenis }}">
    <div class="mb-20 mt-20">
        <button type="submit" id="btnChangePassword" class="btn btn-primary btn-add">Simpan</button>
        <a href="/admin/user/edit/{{ $user->id }}" class="btn btn-warning btn-add">Edit</a>
    </div>
</form>

<script>
    $(document).ready(function () {
        // Preview foto saat file dipilih
        $('#inputFoto').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewFoto').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
        
        $('#detailUserForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/user/update-user-action', formData, '#message-modal')
            });
        });
    });
</script>