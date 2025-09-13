@extends('layouts.admin')
@section('title', 'Edit Menu')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <h3 class="card-title">Edit Menu</h3>
            </div>
            <div class="card-body">
                <form id="menuForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Judul Menu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $menu->title) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">URL <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $menu->url) }}" required>
                                <small class="text-muted">Contoh: /berita, /kontak, /tentang-kami</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon">Icon</label>
                                <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $menu->icon) }}">
                                <small class="text-muted">Contoh: fas fa-home, fas fa-newspaper</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id">Parent Menu</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">-- Pilih Parent Menu --</option>
                                    @foreach($parentMenus as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order">Urutan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $menu->order) }}" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', $menu->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-add">Simpan Perubahan</button>
                        <a href="{{ url('/admin/menu') }}" class="btn btn-secondary btn-add">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#menuForm').submit(function(e) {
            e.preventDefault();
            
            ajxProcess($(this));
        });
    })
</script>



@endsection