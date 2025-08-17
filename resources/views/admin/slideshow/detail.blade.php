@extends('layouts.admin')
@section('title', 'Tambah Slideshow')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <h3 class="card-title">Tambah Slideshow</h3>
            </div>
            <div class="card-body">
                <form onsubmit="return false;" id="form-slideshow" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-10">
                        <label for="title">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$data->title ?? ''}}" required>
                    </div>
                    <div class="form-group mb-10">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" cols="30" rows="4" style="height: auto;" name="deskripsi" rows="3">{{$data->deskripsi ?? ''}}</textarea>
                    </div>
                    <div class="form-group mb-10">
                        <label for="link">Link</label>
                        <input type="text" class="form-control" id="link" name="link" value="{{$data->link ?? ''}}">
                    </div>
                    <div class="form-group mb-10">
                        <label for="tombol_text">Teks Tombol</label>
                        <input type="text" class="form-control" id="tombol_text" name="tombol_text" value="{{$data->tombol_text ?? ''}}">
                    </div>
                    <div class="form-group mb-10">
                        <label for="image">Gambar <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" {{$data->image ?? '' ? '' : 'required'}}>
                            <label class="custom-file-label" for="image">Pilih gambar</label>
                        </div>
                        <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB.</small>
                        <div class="preview">
                            @if($data->image ?? '')
                                <img src="{{ asset($data->image) }}" alt="Preview" style="max-width: 250px;" class="img-preview">
                            @endif
                        </div>
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
                    <a href="{{ url('/admin/slideshow') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Menampilkan nama file yang dipilih pada input file
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    $('#form-slideshow').submit(function(e) {
        e.preventDefault();
        let dataInput = new FormData(this);
        confirmModal('Apakah kamu yakin data yang diisi sudah benar?', function(){
            ajxProcess('/admin/slideshow/store', dataInput, '#message-modal');
        })
    });
</script>
@endsection