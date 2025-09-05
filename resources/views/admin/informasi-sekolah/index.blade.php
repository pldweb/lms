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
                                <form id="informasi-sekolah" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf     
                                <div class="form-group row">
                                    <label for="judul" class="col-sm-3 col-form-label">Nama Sekolah</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="{{ $data->nama_sekolah ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">Tagline</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="tagline" name="tagline" value="{{ $data->tagline ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="4" id="alamat" name="alamat">{{ $data->alamat ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">No Telepon</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"  value="{{ $data->nomor_telepon ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">No Handphone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nomor_handphone" name="nomor_handphone"  value="{{ $data->nomor_handphone ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="judul" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="email" name="email"  value="{{ $data->email ?? '' }}">
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
                                        @if($data)
                                            <img id="logoPreview" src="{{ asset('img/' . $data->logo) }}" alt="Logo Preview" class="img-fluid" style="max-height: 150px;">
                                        @else
                                        <div class='alert alert-warning alert-dismissible' style="margin-top: 5px;">Belum ada logo</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="logo" class="col-sm-12 col-form-label">Logo Icon</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" id="favicon" name="favicon">
                                    </div>
                                </div>
                                <div>
                                    <div class="p-2 rounded-2xl">
                                        @if($data)
                                            <img id="faviconPreview" src="{{ asset('img/' . $data->favicon) ?? null }}" alt="Favicon Preview" class="img-fluid" style="max-height: 150px;">
                                        @else
                                        <div class='alert alert-warning alert-dismissible' style="margin-top: 5px;">Belum ada Favicon</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Preview logo ketika file dipilih
                $('#logo').change(function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#logoPreview').attr('src', e.target.result).show();
                            // Hapus alert warning jika ada
                            $('#logoPreview').siblings('.alert-warning').remove();
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Preview favicon ketika file dipilih
                $('#favicon').change(function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#faviconPreview').attr('src', e.target.result).show();
                            // Hapus alert warning jika ada
                            $('#faviconPreview').siblings('.alert-warning').remove();
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            $('#informasi-sekolah').submit(function(e){
                e.preventDefault();
                let dataInput = new FormData(this);
                
                const logoFile = $('#logo')[0].files[0];
                const faviconFile = $('#favicon')[0].files[0];
                
                if (logoFile) {
                    dataInput.append('logo', logoFile);
                }
                
                if (faviconFile) {
                    dataInput.append('favicon', faviconFile);
                }
                
                confirmModal('Anda yakin ingin mengupdate informasi sekolah?', function(){
                    ajxProcess('/admin/informasi-sekolah/store', dataInput, '#message-modal');
                })
            });
        </script>
@endsection