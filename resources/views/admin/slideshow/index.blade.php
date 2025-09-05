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
                        <a href="{{ url('/admin/slideshow/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Slideshow 
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($slideshows->isEmpty())
                    {!! alert("Belum ada slideshow", 'warning') !!}
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-slideshow" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300">No</th>
                                <th class="h6 text-gray-300">Gambar</th>
                                <th class="h6 text-gray-300">Judul</th>
                                <th class="h6 text-gray-300">Deskripsi</th>
                                <th class="h6 text-gray-300">Urutan</th>
                                <th class="h6 text-gray-300">Status</th>
                                <th class="h6 text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($slideshows as $index => $slideshow)
                            <tr>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $index + 1 }}</span></td>
                                <td>
                                    <img src="{{ asset($slideshow->image) }}" alt="{{ $slideshow->title }}" class="img-thumbnail" style="max-height: 70px; max-width: 100px;">
                                </td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $slideshow->title }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit($slideshow->deskripsi, 50) }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $slideshow->urutan }}</span></td>
                                <td>
                                    @if ($slideshow->aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/slideshow/edit/' . $slideshow->id) }}" class="btn btn-sm btn-primary btn-add">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-add" onclick="confirmDelete({{ $slideshow->id }})">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-300">Tidak ada data slideshow</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus slideshow ini?', function() {
            ajxProcess('/admin/slideshow/delete-action/' + id, '', '#message-modal');
        });
    }
</script>
@endsection