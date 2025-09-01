@extends('layouts.admin')
@section('title', 'Manajemen Mata Pelajaran')
@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Manajemen Mata Pelajaran</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/mata-pelajaran/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Mata Pelajaran 
                        </a>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding-top: 0;">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-mata-pelajaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300">No</th>
                                <th class="h6 text-gray-300">Kode</th>
                                <th class="h6 text-gray-300">Nama Mata Pelajaran</th>
                                <th class="h6 text-gray-300">Jenjang</th>
                                <th class="h6 text-gray-300">Semester</th>
                                <th class="h6 text-gray-300">SKS</th>
                                <th class="h6 text-gray-300">Aktif</th>
                                <th class="h6 text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mataPelajaran as $index => $mp)
                            <tr>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ ($mataPelajaran->currentPage() - 1) * $mataPelajaran->perPage() + $index + 1 }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $mp->kode }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $mp->nama }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $mp->jenjang }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $mp->semester }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $mp->sks }}</span></td>
                                <td>
                                    @if($mp->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Aksi">
                                        {{-- Detail Mata Pelajaran --}}
                                        <a href="/admin/mata-pelajaran/show/{{ $mp->id }}" class="btn btn-primary btn-sm btn-add" title="Detail">
                                            <i class="ph ph-eye btn-icon"></i>
                                        </a>
                                        {{-- Edit Mata Pelajaran --}}
                                        <a href="/admin/mata-pelajaran/edit/{{ $mp->id }}" class="btn btn-warning btn-sm btn-add" title="Edit">
                                            <i class="ph ph-pencil btn-icon"></i>
                                        </a>
                                        {{-- Delete Mata Pelajaran --}}
                                        <button type="button" class="btn btn-danger btn-sm btn-add" title="Hapus" onclick="confirmDelete({{ $mp->id }})">
                                            <i class="ph ph-trash btn-icon"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($mataPelajaran->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $mataPelajaran->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        initDataTable("#table-mata-pelajaran");
    });

    function confirmDelete(id) {
        confirmModal('Yakin ingin menghapus mata pelajaran ini?', function(){
            ajxProcess('/admin/mata-pelajaran/delete-action/' + id, null, '#message-modal');
        });
    }
</script>
@endsection
