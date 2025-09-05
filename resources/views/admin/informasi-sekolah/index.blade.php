@extends('layouts.admin')
@section('title', 'Informasi Sekolah')
@section('content')

        <div class="row mt-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-header b-title">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title w-content">
                                Informasi Sekolah
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <form id="halaman-form" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf     
                                <div class="form-group row">
                                    <label for="judul" class="col-sm-3 col-form-label">Nama Sekolah</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" required value="{{ $data->nama_sekolah }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">Tagline</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="tagline" name="tagline" required value="{{ $data->tagline }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="4" id="alamat" name="alamat">{{ $data->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">No Telepon</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required value="{{ $data->nomor_telepon }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">No Handphone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="no_handphone" name="no_handphone" required value="{{ $data->nomor_handphone }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="email" name="email" required value="{{ $data->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-top: 30px;">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary btn-add">Simpan</button>
                                            <a href="{{ url('/admin/halaman') }}" class="btn btn-secondary btn-add">Batal</a>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="logo" class="col-sm-12 col-form-label">Logo Sekolah</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" id="logo" name="logo">
                                    </div>
                                </div>
                                <div>
                                    <div class="p-2 rounded-2xl mt-2.5">
                                        <img id="logoPreview" src="{{ asset('img/' . $data->logo) }}" alt="Logo Preview" class="img-fluid" style="max-height: 150px;">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="logo" class="col-sm-12 col-form-label">Logo Icon</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" id="favicon" name="favicon">
                                    </div>
                                </div>
                                <div style="margin-top: 20px;">
                                    <div class="p-2 rounded-2xl mt-2.5">
                                        <img id="faviconPreview" src="{{ asset('img/' . $data->favicon) ?? null }}" alt="Favicon Preview" class="img-fluid" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection