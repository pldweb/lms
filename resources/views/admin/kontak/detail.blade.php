@extends('layouts.admin')
@section('title', isset($data) ? 'Edit Kontak' : 'Tambah Kontak')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <h3 class="card-title">{{ isset($data) ? 'Edit Kontak' : 'Tambah Kontak' }}</h3>
            </div>
            <div class="card-body">
                <form onsubmit="return false;" id="form-kontak" method="POST">
                    @csrf
                    <div class="form-group mb-10">
                        <label for="nama">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama ?? ''}}" required>
                    </div>
                    <div class="form-group mb-10">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{$data->jabatan ?? ''}}">
                    </div>
                    <div class="form-group mb-10">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$data->email ?? ''}}">
                    </div>
                    <div class="form-group mb-10">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{$data->telepon ?? ''}}">
                    </div>
                    <div class="form-group mb-10">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{$data->alamat ?? ''}}</textarea>
                    </div>
                    <div class="form-group mb-10">
                        <label for="icon">Icon <small>(Font Awesome)</small></label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{$data->icon ?? ''}}" placeholder="fas fa-user">
                        <small class="form-text text-muted">Contoh: fas fa-user, fas fa-envelope, fas fa-phone, dll.</small>
                    </div>
                    <div class="form-group mb-10">
                        <label for="urutan">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="{{$data->urutan ?? ''}}" min="0">
                    </div>
                    
                    <div class="form-group mb-10">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="aktif" name="aktif" {{$data->aktif ?? '' == '1' ? 'checked' : ''}}>
                            <label class="custom-control-label" for="aktif">Aktif</label>
                        </div>
                    </div>
                    <input type="hidden" id="id" name="id" value="{{$data->id ?? ''}}">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('/admin/kontak') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#form-kontak').submit(function(e) {
        e.preventDefault();
        let dataInput = new FormData(this);
        confirmModal('Apakah kamu yakin data yang diisi sudah benar?', function(){
            ajxProcess('/admin/kontak/store', dataInput, '#message-modal');
        })
    });
</script>
@endsection