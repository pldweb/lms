@extends('layouts.admin')
@section('title', 'Manajemen Tahun Ajaran')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Manajemen Tahun Ajaran</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/tahun-ajaran/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Tahun Ajaran 
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
                            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table-tahun-ajaran" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">No</th>
                                            <th class="h6 text-gray-300">Nama Tahun Ajaran</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            <th class="h6 text-gray-300">Keterangan</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tahunAjaran as $index => $ta)
                                        <tr>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $index + 1 }}</span></td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $ta->nama }}</span></td>
                                            <td>
                                                @if($ta->status === 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Non-Aktif</span>
                                                @endif
                                            </td>
                                            <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $ta->keterangan }}</span></td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Aksi">
                                                    {{-- Detail Tahun Ajaran --}}
                                                    <a href="/admin/tahun-ajaran/show/{{ $ta->id }}" class="btn btn-primary btn-sm btn-add" title="Detail">
                                                        <i class="ph ph-eye btn-icon"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data tahun ajaran</td>
                                        </tr>
                                        @endforelse
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
            $('#table-tahun-ajaran tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
            });
        });

        // Export Data (CSV / JSON)
        $('#exportOptions').on('change', function () {
            const format = $(this).val();
            const $table = $('#table-tahun-ajaran');
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

        // Fungsi Export CSV
        function downloadCSV(data) {
            const csv = data.map(row => Object.values(row).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'users.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        // Fungsi Export JSON
        function downloadJSON(data) {
            const json = JSON.stringify(data, null, 2);
            const blob = new Blob([json], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'users.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });
</script>
@endsection
