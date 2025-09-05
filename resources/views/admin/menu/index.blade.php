@extends('layouts.admin')
@section('title', 'Menu Management')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kelola Menu</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/menu/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Menu
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($menu->isEmpty())
                    {!! alert('Belum ada menu', 'warning') !!}
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-menu" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300">No</th>
                                <th class="h6 text-gray-300">Judul</th>
                                <th class="h6 text-gray-300">Url</th>
                                <th class="h6 text-gray-300">Icon</th>
                                <th class="h6 text-gray-300">Parent</th>
                                <th class="h6 text-gray-300">Urutan</th>
                                <th class="h6 text-gray-300">Status</th>
                                <th class="h6 text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menu as $index => $item)
                            <tr>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $index + 1 }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->judul }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->url }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->icon }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->parent }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span></td>
                                <td>
                                    @if ($item->aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/kontak/edit/' . $item->id) }}" class="btn btn-sm btn-primary btn-add">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-add" onclick="confirmDelete({{ $item->id }})">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                           {!! alert('Belum ada menu', 'warning') !!}
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
        confirmModal('Apakah Anda yakin ingin menghapus menu ini?', function() {
            ajxProcess('/admin/menu/delete-action/' + id, '', '#message-modal');
        });
    }

    $(document).ready(function() {
        initDataTable("#table-menu");
    });
</script>
@endsection