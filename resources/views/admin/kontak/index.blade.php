@extends('layouts.admin')
@section('title', 'Kontak')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kelola Kontak</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                        @if(Auth::user()->hasRole('Admin'))
                        <a onclick="showModal('/admin/kontak/create', 'Tambah Kontak')" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Kontak
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($kontak->isEmpty())
                    {!! alert('Belum ada kontak', 'warning') !!}
                @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="kontakTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">Nama</th>
                                            <th class="h6 text-gray-300">Jabatan</th>
                                            <th class="h6 text-gray-300">Email</th>
                                            <th class="h6 text-gray-300">Telepon</th>
                                            <th class="h6 text-gray-300">Icon</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <th class="h6 text-gray-300">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kontak as $item)
                                        <tr>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->nama }}</span>
                                                </div>
                                            </td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->jabatan }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->email }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->telepon }}</span></td>
                                            <td><i class="{{ $item->icon }}"></i></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span></td>
                                            <td>
                                                <span class="badge bg-{{ $item->aktif ? 'success' : 'danger' }} text-{{ $item->aktif ? 'success' : 'danger' }}-soft text-sm" onclick="toggleStatus({{ $item->id }})">
                                                    {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <td>
                                                <button onclick="showModal('/admin/kontak/edit/{{ $item->id }}', 'Data Kontak')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm"><i class="ph ph-pencil"></i></button>
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
        initDataTable("#kontakTable");
    });
    
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus kontak ini?', function() {
            ajxProcess('/admin/kontak/delete-action/' + id, '', '#message-modal');
        });
    }
    
    function toggleStatus(id) {
        confirmModal('Apakah Anda yakin ingin mengubah status kontak ini?', function() {
            ajxProcess('/admin/kontak/toggle-status/' + id, '', '#message-modal');
        });
    }
</script>
@endsection