@extends('layouts.admin')
@section('title', 'Menu Management')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Menu Management</h1>
    <a href="{{ url('/admin/menu/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Menu
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Parent</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($menus as $menu)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $menu->title }}</td>
                        <td>{{ $menu->url }}</td>
                        <td><i class="{{ $menu->icon }}"></i> {{ $menu->icon }}</td>
                        <td>-</td>
                        <td>{{ $menu->order }}</td>
                        <td>
                            <span class="badge {{ $menu->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $menu->active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ url('/admin/menu/edit/' . $menu->id) }}" class="btn btn-primary btn-sm btn-add">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ url('/admin/menu/delete/' . $menu->id) }}" class="btn btn-danger btn-sm btn-add" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    @if($menu->children->count() > 0)
                        @foreach($menu->children as $child)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>— {{ $child->title }}</td>
                            <td>{{ $child->url }}</td>
                            <td><i class="{{ $child->icon }}"></i> {{ $child->icon }}</td>
                            <td>{{ $menu->title }}</td>
                            <td>{{ $child->order }}</td>
                            <td>
                                <span class="badge {{ $child->active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $child->active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ url('/admin/menu/edit/' . $child->id) }}" class="btn btn-primary btn-sm btn-add">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ url('/admin/menu/delete/' . $child->id) }}" class="btn btn-danger btn-sm btn-add" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection