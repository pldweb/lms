<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info"> Data khusus {{ ucfirst($jenis) }} dapat ditambahkan di sini sesuai kebutuhan. </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="foto_profile" class="col-md-3">Foto Profile</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="inputFoto" name="foto_profile" accept="image/*">
                <small class="form-text text-muted">Upload foto profile dengan format JPG, PNG, atau JPEG.</small>
            </div>
            <div class="col-md-3">
                <img id="previewFoto" src="{{ isset($user) && $user->foto_profile ? asset('storage/'.$user->foto_profile) : asset('admin/images/thumbs/avatar.png') }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;" alt="Preview Foto">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="nisn" class="col-md-3">Nama</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputNama" name="nama" placeholder="Nama" value="{{ isset($user) ? $user->nama : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="nisn" class="col-md-3">Nama Lengkap</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputNamaLengkap" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ isset($user) ? $user->nama_lengkap : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="nisn" class="col-md-3">Email</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{ isset($user) ? $user->email : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="password" class="col-md-3">Password</label>
            <div class="col-md-9">
                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="tanggal_lahir" class="col-md-3">Tanggal Lahir</label>
            <div class="col-md-9">
                <input type="date" class="form-control" id="inputTanggalLahir" name="tanggal_lahir" value="{{ isset($user) ? $user->tanggal_lahir : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <label for="jenis_kelamin" class="col-md-3">Jenis Kelamin</label>
            <div class="col-md-9">
                <select class="form-control select2" id="inputJenisKelamin" name="jenis_kelamin">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="laki-laki" {{ isset($user) && $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ isset($user) && $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
    </div>

    @if($jenis == 'siswa')
    <div class="col-md-12">
        <div class="form-group row">
            <label for="nisn" class="col-md-3">NISN</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputNis" name="nis" placeholder="NIS" value="{{ isset($user) ? $user->nis : '' }}">
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group row">
            <label for="nama_orang_tua" class="col-md-3">Nama Orang Tua</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputNamaOrangTua" name="nama_orang_tua" placeholder="Nama Orang Tua" value="{{ isset($user) ? $user->nama_orang_tua : '' }}">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="no_hp_orang_tua" class="col-md-3">No. HP Orang Tua</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputNoHpOrangTua" name="no_hp_orang_tua" placeholder="No. HP Orang Tua" value="{{ isset($user) ? $user->no_hp_orang_tua : '' }}">
            </div>
        </div>
    </div>
    @endif

</div>
<div class="row">
    
    <div class="col-md-12">
        <div class="form-group row">
            <label for="alamat" class="col-md-3">Alamat</label>
            <div class="col-md-9">
                <textarea class="form-control" id="inputAlamat" name="alamat" placeholder="Alamat">{{ isset($user) ? $user->alamat : '' }}</textarea>
                <small class="form-text text-muted">Alamat tidak wajib diisi</small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="no_hp" class="col-md-3">Nomor HP</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputNoHP" name="no_hp" placeholder="Nomor HP" value="{{ isset($user) ? $user->no_hp : '' }}">
                <small class="form-text text-muted">Nomor HP tidak wajib diisi</small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="provinsi" class="col-md-3">Provinsi</label>
            <div class="col-md-9">
                <select class="form-control select2" id="inputProvinsi" name="provinsi">
                    <option value="">Pilih Provinsi</option> @if(isset($provinsi)) @foreach($provinsi as $prov) <option value="{{ $prov->kode }}" {{ isset($user) && $user->provinsi == $prov->kode ? 'selected' : '' }}>{{ $prov->nama }}</option> @endforeach @endif
                </select>
                <small class="form-text text-muted">Provinsi tidak wajib diisi</small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="kota" class="col-md-3">Kota/Kabupaten</label>
            <div class="col-md-9">
                <select class="form-control select2" id="inputKota" name="kota">
                    <option value="">Pilih Kota/Kabupaten</option> @if(isset($user) && isset($kota)) @foreach($kota as $k) <option value="{{ $k->kode }}" {{ isset($user) && $user->kota == $k->kode ? 'selected' : '' }}>{{ $k->nama }}</option> @endforeach @endif
                </select>
                <small class="form-text text-muted">Kota/Kabupaten tidak wajib diisi</small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="kecamatan" class="col-md-3">Kecamatan</label>
            <div class="col-md-9">
                <select class="form-control select2" id="inputKecamatan" name="kecamatan">
                    <option value="">Pilih Kecamatan</option> @if(isset($user) && isset($kecamatan)) @foreach($kecamatan as $kec) <option value="{{ $kec->kode }}" {{ isset($user) && $user->kecamatan == $kec->kode ? 'selected' : '' }}>{{ $kec->nama }}</option> @endforeach @endif
                </select>
                <small class="form-text text-muted">Kecamatan tidak wajib diisi</small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="kelurahan" class="col-md-3">Kelurahan/Desa</label>
            <div class="col-md-9">
                <select class="form-control select2" id="inputKelurahan" name="kelurahan">
                    <option value="">Pilih Kelurahan/Desa</option> @if(isset($user) && isset($kelurahan)) @foreach($kelurahan as $kel) <option value="{{ $kel->kode }}" {{ isset($user) && $user->kelurahan == $kel->kode ? 'selected' : '' }}>{{ $kel->nama }}</option> @endforeach @endif
                </select>
                <small class="form-text text-muted">Kelurahan/Desa tidak wajib diisi</small>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group row">
            <label for="kodepos" class="col-md-3">Kode Pos</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="inputKodepos" name="kodepos" placeholder="Kode Pos" value="{{ isset($user) ? $user->kodepos : '' }}">
                <small class="form-text text-muted">Kode Pos tidak wajib diisi</small>
            </div>
        </div>
    </div>
</div>
<div class="form-group row mt-20 mb-20">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <button type="submit" class="btn btn-primary btn-add">Simpan Data Siswa</button>
        <a href="/admin/user" class="btn btn-secondary btn-add">Kembali</a>
    </div>
</div>