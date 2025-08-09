@extends('layouts.admin')
@section('title', isset($jenis) ? ucfirst($jenis) : 'Artikel')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data {{ ucfirst($jenis) ?? 'Pengumuman' }}</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/artikel/create') }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                                <i class="ph ph-plus"></i> Tambah Artikel
                        </a>                   
                        <select id="exportOptions" class="form-select w-auto mb-3 mr-2">
                            <option value="">Export</option>
                            <option value="csv">Export to CSV</option>
                            <option value="json">Export to JSON</option>
                        </select>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding-top: 0;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="artikelTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="fixed-width">
                                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox" id="selectAll">
                                            </th>
                                            <th class="h6 text-gray-300">Judul</th>
                                            @if(!isset($jenis))
                                            <th class="h6 text-gray-300">Jenis</th>
                                            @endif
                                            <th class="h6 text-gray-300">Status</th>
                                            <th class="h6 text-gray-300">Tanggal Publish</th>
                                            <th class="h6 text-gray-300">Views</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($artikel as $item)
                                            <tr>
                                                <td class="fixed-width">
                                                    <div class="form-check">
                                                        <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="flex-align gap-8">
                                                        @if($item->gambar)
                                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" class="w-40 h-40 rounded object-fit-cover">
                                                        @endif
                                                        <div>
                                                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->judul }}</span>
                                                            @if($item->ringkasan)
                                                                <p class="text-sm text-gray-500 mb-0">{{ Str::limit($item->ringkasan, 50) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                @if(!isset($jenis))
                                                <td>
                                                    <span class="badge bg-{{ $item->jenis == 'berita' ? 'primary' : 'info' }}">
                                                        {{ ucfirst($item->jenis) }}
                                                    </span>
                                                </td>
                                                @endif
                                                <td>
                                                    <span class="badge bg-{{ $item->status == 'publish' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                                        {{ $item->tanggal_publish ? $item->tanggal_publish->format('d/m/Y H:i') : '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ number_format($item->views) }}</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-add btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ url('/admin/artikel/detail/' . $item->id) }}">
                                                                <i class="ph ph-eye"></i> Detail
                                                            </a></li>
                                                            <li><a class="dropdown-item" href="{{ url('/admin/artikel/edit/' . $item->id) }}">
                                                                <i class="ph ph-pencil"></i> Edit
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" onclick="toggleStatus({{ $item->id }})">
                                                                    <i class="ph ph-{{ $item->status == 'publish' ? 'eye-slash' : 'eye' }}"></i> 
                                                                    {{ $item->status == 'publish' ? 'Jadikan Draft' : 'Publish' }}
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#" onclick="deleteArtikel({{ $item->id }})">
                                                                    <i class="ph ph-trash"></i> Hapus
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            let keyword = $(this).val().toLowerCase();
            $('#artikelTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
            });
        });

        $('#artikelTable').DataTable({
            paging: false,
            lengthChange: true,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: true,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, -1] } 
            ]
        });

        $('#selectAll').on('change', function () {
            const isChecked = $(this).prop('checked');
            $('.form-check .form-check-input').prop('checked', isChecked);
        });

        // Export Data
        $('#exportOptions').on('change', function () {
            const format = $(this).val();
            const $table = $('#artikelTable');
            const headers = [];
            const data = [];

            $table.find('thead th').each(function () {
                headers.push($(this).text().trim());
            });

            $table.find('tbody tr').each(function () {
                const row = {};
                $(this).find('td').each(function (index) {
                    row[headers[index]] = $(this).text().trim();
                });
                data.push(row);
            });

            if (format === 'csv') {
                downloadCSV(data);
            } else if (format === 'json') {
                downloadJSON(data);
            }
        });

        function downloadCSV(data) {
            const csv = data.map(row => Object.values(row).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'artikel.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function downloadJSON(data) {
            const json = JSON.stringify(data, null, 2);
            const blob = new Blob([json], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'artikel.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });

    function toggleStatus(id) {
        if (confirm('Apakah Anda yakin ingin mengubah status artikel ini?')) {
            $.ajax({
                url: '{{ url("/admin/artikel/toggle-status") }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengubah status artikel');
                }
            });
        }
    }

    function deleteArtikel(id) {
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini? Data yang dihapus tidak dapat dikembalikan.')) {
            $.ajax({
                url: '{{ url("/admin/artikel/destroy") }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus artikel');
                }
            });
        }
    }
</script>
@endsection
