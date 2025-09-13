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
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                        @if(Auth::user()->hasRole('Admin'))
                        <a onclick="showModal('/admin/menu/create', 'Tambah Menu')" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Menu
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($menu->count() == 0)
                    {!! alert('Belum ada menu', 'warning') !!}
                @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="menuTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%" class="h6 text-gray-300" style="width: 5px;">No</th>
                                            <th class="h6 text-gray-300">Judul</th>
                                            <th class="h6 text-gray-300">Url</th>
                                            <th class="h6 text-gray-300">Parent</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <th class="h6 text-gray-300">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menu as $index => $item)
                                        <tr>
                                            <td>
                                                <span class="h6 mb-0 fw-medium text-gray-300">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->title }}</span>
                                                </div>
                                            </td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->url }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->parent ? $item->parent->title : '-' }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->order }}</span></td>
                                            <td>
                                                <span class="badge bg-{{ $item->active ? 'success' : 'danger' }} text-{{ $item->active ? 'success' : 'danger' }}-soft text-sm" onclick="toggleStatus({{ $item->id }})">
                                                    {{ $item->active ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <td>
                                                <button onclick="showModal('/admin/menu/detail/{{ $item->id }}', 'Data Detail Menu')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm"><i class="ph ph-pencil"></i></button>
                                                <button onclick="confirmDelete({{ $item->id }})" class="btn btn-danger btn-add btn-sm"><i class="ph ph-trash btn-icon"></i></button>
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
        initDataTable("#menuTable");
    });

    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus menu ini?', function() {
            ajxProcess('/admin/menu/delete/' + id, '', '#message-modal');
        });
    }
    
    function toggleStatus(id) {
        ajxProcess('/admin/menu/toggle-status/' + id, '', '#message-modal');
    }
</script>
@endsection