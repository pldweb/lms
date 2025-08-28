@extends('layouts.admin')
@section('title', 'Manajemen Social Media')
@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kelola Social Media</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/social-media/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Social Media
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-social-media" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300 fixed-width">No</th>
                                <th class="h6 text-gray-300">Platform</th>
                                <th class="h6 text-gray-300">Icon</th>
                                <th class="h6 text-gray-300">Link</th>
                                <th class="h6 text-gray-300">Deskripsi</th>
                                <th class="h6 text-gray-300">Urutan</th>
                                <th class="h6 text-gray-300">Status</th>
                                <th class="h6 text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($socialMedia as $index => $item)
                            <tr>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $index + 1 }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->nama }}</span></td>
                                <td>
                                    <i class="{{ $item->icon }} fa-lg text-primary"></i>
                                </td>
                                <td>
                                    <a href="{{ $item->link }}" target="_blank" class="text-decoration-underline">
                                        {{ Str::limit($item->link, 30) }}
                                    </a>
                                </td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit($item->deskripsi ?? '-', 50) }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span></td>
                                <td>
                                    @if ($item->aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/social-media/edit/' . $item->id) }}" class="btn btn-sm btn-primary btn-add">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-add" onclick="confirmDelete({{ $item->id }})">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-300">Tidak ada data social media</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus social media ini?', function() {
            ajxProcess('/admin/social-media/delete-action/' + id, '', '#message-modal');
        });
    }

    $(document).ready(function () {
        $('#table-social-media').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, 7] } 
            ]
        });
    });
</script>
@endsection