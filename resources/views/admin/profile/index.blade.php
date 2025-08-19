@extends('layouts.admin')
@section('title', 'Profile')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Halaman Profile</h3>
            </div>
            <div class="card-body" style="padding-top: 0;">
                <form id="updateProfile" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <img src="{{$user->foto_profile ? Storage::url($user->foto_profile) : asset('admin/images/thumbs/avatar.png')}}" style="width: 300px; height: 300px; border-radius: 50%; object-fit: cover;" alt="avatar" class="img-fluid">
                                </div>
                            </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="{{$user->nama}}">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_lengkap" id="name" placeholder="Nama Lengkap" value="{{$user->nama_lengkap}}">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$user->email}}">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <label for="phone">No HP</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+62</span>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="No HP" value="{{$user->no_hp ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="{{$user->alamat ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <select class="form-control" id="provinsi" name="provinsi">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinsi as $prov)
                                                <option value="{{ $prov->kode }}" {{ ($user->provinsi == $prov->kode) ? 'selected' : '' }}>
                                                    {{ $prov->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="kota">Kota/Kabupaten</label>
                                        <select class="form-control" id="kota" name="kota" disabled>
                                            <option value="">Pilih Kota</option>
                                            @if($user->provinsi)
                                                @foreach(\App\Helper\LokasiHelper::getKota($user->provinsi)['data'] as $kota)
                                                    <option value="{{$kota->kode}}" {{$user->kota == $kota->kode ? 'selected' : ''}}>{{$kota->nama}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <select class="form-control" id="kecamatan" name="kecamatan" disabled>
                                            <option value="">Pilih Kecamatan</option>
                                            @if($user->kota)
                                                @foreach(\App\Helper\LokasiHelper::getKecamatan($user->kota)['data'] as $kecamatan)
                                                    <option value="{{$kecamatan->kode}}" {{$user->kecamatan == $kecamatan->kode ? 'selected' : ''}}>{{$kecamatan->nama}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <select class="form-control" id="kelurahan" name="kelurahan" disabled>
                                            <option value="">Pilih Kelurahan</option>
                                            @if($user->kecamatan)
                                                @foreach(\App\Helper\LokasiHelper::getKelurahan($user->kecamatan)['data'] as $kelurahan)
                                                    <option value="{{$kelurahan->kode}}" {{$user->kelurahan == $kelurahan->kode ? 'selected' : ''}}>{{$kelurahan->nama}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="kodepos">Kode Pos</label>
                                        <input type="text" class="form-control" id="kodepos" name="kodepos" placeholder="Kode Pos" value="{{$user->kodepos ?? ''}}">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="id" name="id" value="{{$user->id}}">
                            <div class="form-group mt-20 mb-20">
                                <button type="submit" class="btn btn-primary btn-block btn-add">Update Profile</button>
                                <button onclick="showModal('/admin/profile/upload-foto', 'Upload Foto Profile')" class="btn btn-primary btn-block btn-add">Ubah Foto Profile</button>
                                <button onclick="showModal('/admin/profile/change-password', 'Ubah Password')" class="btn btn-primary btn-block btn-add">Ubah Password</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Edid Data Diri
        $('#updateProfile').submit(function(e){
            e.preventDefault();
            let dataInput = new FormData(this);
            confirmModal('Anda yakin ingin mengupdate profile?', function(){
                ajxProcess('/admin/profile/update-profile', dataInput, '#message-modal');
            })
        });

        // Edit Password
        $('#changePassword').submit(function(e){
            e.preventDefault();
            let dataInput = new FormData(this);
            confirmModal('Anda yakin ingin mengupdate password?', function(){
                ajxProcess('/admin/profile/change-password', dataInput, '#message-modal');
            })
        });

        // Edit Foto
        $('#uploadFoto').submit(function(e){
            e.preventDefault();
            let dataInput = new FormData(this);
            confirmModal('Anda yakin ingin mengupdate foto profile?', function(){
                ajxProcess('/admin/profile/upload-foto', dataInput, '#message-modal');
            })
        });
    });

    $(document).ready(function () {
        // Enable dropdown yang sudah memiliki data
        @if($user->provinsi)
            $('#kota').prop('disabled', false);
        @endif
        @if($user->kota)
            $('#kecamatan').prop('disabled', false);
        @endif
        @if($user->kecamatan)
            $('#kelurahan').prop('disabled', false);
        @endif
        
        $('#provinsi').on('change', function () {
            let provinsiId = $(this).val();
            // Reset semua dropdown di bawahnya
            $('#kota').html('<option value="">Pilih Kota</option>').prop('disabled', true);
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>').prop('disabled', true);
            if (provinsiId) {
                ajxDropdown("{{ url('/lokasi/kota') }}/" + provinsiId, '#kota', 'Pilih Kota');
            }
        });

        $('#kota').on('change', function () {
            let kotaId = $(this).val();
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>').prop('disabled', true);
            if (kotaId) {
                ajxDropdown("{{ url('/lokasi/kecamatan') }}/" + kotaId, '#kecamatan', 'Pilih Kecamatan');
            }
        });

        $('#kecamatan').on('change', function () {
            let kecamatanId = $(this).val();
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>').prop('disabled', true);
            if (kecamatanId) {
                ajxDropdown("{{ url('/lokasi/kelurahan') }}/" + kecamatanId, '#kelurahan', 'Pilih Kelurahan');
            }
        });
    });

</script>


@endsection
