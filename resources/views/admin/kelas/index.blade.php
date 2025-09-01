@extends('layouts.admin')
@section('title', 'Manajemen Kelas')
@section('content')
<div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header b-title">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title w-content">Kelola Kelas</h3>
                        <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                            <a href="/admin/kelas/create" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                                <i class="ph ph-plus"></i> Tambah Kelas
                            </a>
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                                <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body relative overflow-x-auto">
                    <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="table-kelas" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="h6 text-gray-300">No</th>
                                                <th class="h6 text-gray-300">Kode</th>
                                                <th class="h6 text-gray-300">Nama Kelas</th>
                                                <th class="h6 text-gray-300">Semester</th>
                                                <th class="h6 text-gray-300">Kapasitas</th>
                                                <th class="h6 text-gray-300">Status</th>
                                                <th class="h6 text-gray-300">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($kelas as $index => $kls)
                                            <tr>
                                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ ($kelas->currentPage() - 1) * $kelas->perPage() + $index + 1 }}</span></td>
                                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $kls->kode }}</span></td>
                                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $kls->nama }}</span></td>
                                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $kls->semester }}</span></td>
                                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $kls->kapasitas }} siswa</span></td>
                                                <td>
                                                    @if($kls->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non-Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/admin/kelas/edit/{{ $kls->id }}" class="btn btn-primary btn-sm btn-add" title="Edit">
                                                        <i class="ph ph-pencil btn-icon"></i>
                                                    </a>
                                                    <a href="/admin/kelas/delete/{{ $kls->id }}" class="btn btn-danger btn-sm btn-add" title="Hapus" onclick="confirmDelete({{ $kls->id }})">
                                                        <i class="ph ph-trash btn-icon"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                @if($kelas->hasPages())
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $kelas->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        initDataTable("#table-kelas");
    })
</script>
@endsection
