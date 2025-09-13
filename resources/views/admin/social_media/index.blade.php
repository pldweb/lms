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
                        <a onclick="showModal('/admin/social-media/create', 'Tambah Media Sosial')" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Media Sosial
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($socialMedia->count() == 0)
                    {!! alert('Belum ada menu', 'warning') !!}
                @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="socialMediaTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">Media Sosial</th>
                                            <th class="h6 text-gray-300">Icon</th>
                                            <th class="h6 text-gray-300">URL</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <th class="h6 text-gray-300">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($socialMedia as $index => $item)
                                        <tr>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->nama }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <img class="" style="max-height: 25px;" src="{{$item->icon ? Storage::url($item->icon) : ''}}" alt="{{ $item->nama }}"></img>
                                            </td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->link }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span></td>
                                            <td>
                                                <span class="badge bg-{{ $item->aktif ? 'success' : 'danger' }} text-{{ $item->aktif ? 'success' : 'danger' }}-soft text-sm" onclick="toggleStatus({{ $item->id }})">
                                                    {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            @if(Auth::user()->hasRole('Admin'))
                                            <td>
                                                <button onclick="showModal('/admin/social-media/edit/{{ $item->id }}', 'Data Sosial Media')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm"><i class="ph ph-pencil"></i></button>
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
        initDataTable("#socialMediaTable");
    });

    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus menu ini?', function() {
            ajxProcess('/admin/menu/delete/' + id, '', '#message-modal');
        });
    }
    
    function toggleStatus(id) {
        confirmModal('Apakah Anda yakin ingin mengubah status menu ini?', function() {
            ajxProcess('/admin/menu/toggle-status/' + id, '', '#message-modal');
        });
    }
</script>
@endsection