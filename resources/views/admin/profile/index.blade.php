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
                <form id="updateProfile" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                            <div class="form-group">
                                <img src="{{asset('admin/images/thumbs/user-img.png')}}" style="width: 300px; height: 300px; border-radius: 50%; object-fit: cover;" alt="avatar" class="img-fluid">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-block">Ubah Foto Profile</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <div class="form-group">
                                        <label for="phone">No HP</label>
                                        <input type="text" class="form-control" id="phone" placeholder="No HP">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="address">Provinsi</label>
                                        <select class="form-control" id="provinsi" name="provinsi">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinsi as $prov)
                                                <option value="{{$prov['kode']}}">{{$prov['nama']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="address">Kota</label>
                                        <select class="form-control" id="kota" name="kota">
                                            <option value="">Pilih Kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="address">Kecamatan</label>
                                        <select class="form-control" id="kecamatan" name="kecamatan">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="address">Desa</label>
                                        <select class="form-control" id="desa" name="desa">
                                            <option value="">Pilih Desa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-20 mb-20">
                                <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
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
        $('#updateProfile').submit(function(){
                let dataInput = new FormData(this);
                ajxProcess('/admin/profile/update', dataInput, '#message' );
                return false;
        });

        $('#provinsi, #kota, #kecamatan, #desa').select2({
            theme: 'bootstrap-5' // Ganti 'bootstrap-5' dengan 'bootstrap-4' jika perlu
        });

        // Event listener untuk perubahan dropdown
        $('#provinsi').on('change', function() {
            let provinsiId = $(this).val();
            // Reset semua dropdown anak
            $('#kota, #kecamatan, #desa').val(null).trigger('change').html('<option value="">Pilih...</option>').prop('disabled', true);
            if (provinsiId) {
                ajxDropdown(
                    "{{ url('/lokasi/kota') }}/" + provinsiId,
                    '#kota',
                    'Pilih Kota'
                );
            }
        });

        $('#kota').on('change', function() {
            let kotaId = $(this).val();
            $('#kecamatan, #desa').val(null).trigger('change').html('<option value="">Pilih...</option>').prop('disabled', true);
            if (kotaId) {
                ajxDropdown(
                    "{{ url('/lokasi/kecamatan') }}/" + kotaId,
                    '#kecamatan',
                    'Pilih Kecamatan'
                );
            }
        });

        $('#kecamatan').on('change', function() {
            let kecamatanId = $(this).val();
            $('#desa').val(null).trigger('change').html('<option value="">Pilih...</option>').prop('disabled', true);
            if (kecamatanId) {
                ajxDropdown(
                    "{{ url('/lokasi/desa') }}/" + kecamatanId,
                    '#desa',
                    'Pilih Desa'
                );
            }
        });
    });
</script>


@endsection
