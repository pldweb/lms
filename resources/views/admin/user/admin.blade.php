@extends('layouts.admin')
@section('title', 'Admin')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data {{ ucfirst($jenis) }}</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/user/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah {{ ucfirst($jenis) }} 
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
                                <table id="studentTable" class="table table-striped table-hover">
                                    <thead>
                                            <tr>
                                                <th class="fixed-width">
                                                    <input class="form-check-input border-gray-200 rounded-4" type="checkbox" id="selectAll">
                                                </th>
                                                <th class="h6 text-gray-300">Nama</th>
                                                <th class="h6 text-gray-300">Email</th>
                                                <th class="h6 text-gray-300">Aksi</th>
                                            </tr>
                                    </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="fixed-width">
                                                        <div class="form-check">
                                                            <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="flex-align gap-8">
                                                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->nama }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->email }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/admin/user/detail') }}/{{ $user->id }}" class="btn btn-primary btn-add btn-sm">Detail</a>
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
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#searchInput').on('keyup', function () {
            let keyword = $(this).val().toLowerCase();

            $('#studentTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
            });
        });

        $('#studentTable').DataTable({
            paging: false,
            lengthChange: true,
            searching: false,
            ordering: false,
            info: true,
            autoWidth: true,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, 3] } 
            ]
        });

        $('#selectAll').on('change', function () {
            const isChecked = $(this).prop('checked');
            $('.form-check .form-check-input').prop('checked', isChecked);
        });

        // Export Data (CSV / JSON)
        $('#exportOptions').on('change', function () {
            const format = $(this).val();
            const $table = $('#studentTable');
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
