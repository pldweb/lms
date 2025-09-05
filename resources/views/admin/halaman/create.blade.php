@extends('layouts.admin')
@section('title', 'Tambah Halaman Baru')
@push('styles')
<script src="https://cdn.tiny.cloud/1/sn32vy26z8kumz26wibs2fxo0g1tt4jyps2d26s2epz27j2m/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<style>
.tox-tinymce {
    border-radius: 6px !important;
    border: 1px solid #d1d5db !important;
    margin-top: 5px;
}
.tox .tox-edit-area__iframe {
    background-color: #fff !important;
}
.tox .tox-toolbar__group {
    padding: 0 4px !important;
}
.tox .tox-toolbar {
    background-color: #f8f9fa !important;
}
.col-form-label {
    font-weight: 500;
}
</style>
@endpush
@section('content')
    <div class="row mt-20">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title w-content">
                                Tambah Halaman
                            </h3>
                            <a href="{{ url('/admin/halaman') }}" class="btn btn-secondary btn-add">
                                <i class="ph ph-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="halaman-form" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf
                            <div class="form-group row">
                                <label for="judul" class="col-sm-2 col-form-label">Judul Halaman</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="draft">Draft</option>
                                        <option value="publish">Publish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isi" class="col-sm-2 col-form-label">Isi Konten</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control tinymce-editor" id="isi" name="isi" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary btn-add">Simpan</button>
                                    <a href="{{ url('/admin/halaman') }}" class="btn btn-secondary btn-add">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function(){
            TinyMCE('.tinymce-editor');

            $('#halaman-form').submit(function(e) {
                e.preventDefault();
                let data = new FormData(this);
                confirmModal('Apakah Anda yakin ingin menyimpan halaman ini?', function() {
                    ajxProcess('/admin/halaman/store', data, '#message-modal');
                });
            });
        });
    </script>
@endsection
