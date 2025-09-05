@extends('layouts.admin')
@section('title', 'Kategori Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data Kategori Galeri</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/galeri/kategori-create') }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Kategori
                        </a>                   
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($kategori->isEmpty())
                    {!! alert("Belum ada kategori", 'warning') !!}
                @else
                <table id="kategoriTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">Nama Kategori</th>
                                            <th class="h6 text-gray-300">Cover</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            <th class="h6 text-gray-300">Jumlah Item</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategori as $item)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->nama_kategori }}</span>
                                                        @if($item->deskripsi)
                                                            <p class="text-sm text-gray-500 mb-0">{{ Str::limit($item->deskripsi, 50) }}</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($item->gambar_cover)
                                                        <img src="{{ asset('img/galeri/kategori/' . $item->gambar_cover) }}" alt="Cover" class="w-40 h-40 rounded object-fit-cover">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->status == 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-warning">Non-Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->galeri_count }}</span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-add btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ url('/admin/galeri/kategori-edit/' . $item->id) }}">
                                                                <i class="ph ph-pencil"></i> Edit
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><button class="dropdown-item text-danger" onclick="deleteKategori({{ $item->id }})">
                                                                <i class="ph ph-trash"></i> Hapus
                                                            </button></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable if needed
        if (typeof DataTable !== 'undefined') {
            $('#kategoriTable').DataTable({
                responsive: true,
                pageLength: 10,
                paging: false,
                searching: false,
                ordering: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#kategoriTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Select all checkbox
        $('#selectAll').change(function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });
    });

    function deleteKategori(id) {
        confirmModal('Apakah Anda yakin ingin menghapus kategori ini?', function() {
            $.ajax({
                url: `/admin/galeri/kategori/delete/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        if (typeof successAlert === 'function') {
                            $('body').append(successAlert(response.message, null, '', location.href));
                        } else {
                            alert(response.message);
                            location.reload();
                        }
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat menghapus kategori';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    if (typeof errorAlert === 'function') {
                        $('body').append(errorAlert(errorMessage));
                    } else {
                        alert(errorMessage);
                    }
                }
            });
        });
    }
</script>

@endsection
