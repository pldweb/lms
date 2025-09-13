@extends('layouts.admin')
@section('title', 'Kelola Slideshow')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kelola Slideshow</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                        @if(Auth::user()->hasRole('Admin'))
                        <a onclick="showModal('/admin/slideshow/create', 'Tambah Slideshow')" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Slideshow
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($slideshows->isEmpty())
                    {!! alert("Belum ada slideshow", 'warning') !!}
                @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="slideshowTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">No</th>
                                            <th class="h6 text-gray-300">Gambar</th>
                                            <th class="h6 text-gray-300">Judul</th>
                                            <th class="h6 text-gray-300">Deskripsi</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <th class="h6 text-gray-300">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($slideshows as $index => $slideshow)
                                        <tr>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="{{ asset($slideshow->image) }}" alt="{{ $slideshow->title }}" class="img-thumbnail" style="max-height: 70px; max-width: 100px;">
                                            </td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $slideshow->title }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit($slideshow->deskripsi, 50) }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $slideshow->urutan }}</span></td>
                                            <td>
                                                <span class="badge bg-{{ $slideshow->aktif ? 'success' : 'danger' }} text-{{ $slideshow->aktif ? 'success' : 'danger' }}-soft text-sm" onclick="toggleStatus({{ $slideshow->id }})">
                                                    {{ $slideshow->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <td>
                                                <button onclick="showModal('/admin/slideshow/edit/{{ $slideshow->id }}', 'Data Slideshow')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm"><i class="ph ph-pencil"></i></button>
                                                <button onclick="confirmDelete({{ $slideshow->id }})" class="btn btn-danger btn-add btn-sm"><i class="ph ph-trash btn-icon"></i></button>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        initDataTable("#slideshowTable");
    });
    
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus slideshow ini?', function() {
            ajxProcess('/admin/slideshow/delete-action/' + id, '', '#message-modal');
        });
    }
    
    function toggleStatus(id) {
        confirmModal('Apakah Anda yakin ingin mengubah status slideshow ini?', function() {
            ajxProcess('/admin/slideshow/toggle-status/' + id, '', '#message-modal');
        });
    }
</script>
@endsection