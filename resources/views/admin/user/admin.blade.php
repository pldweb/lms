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
                        @if(Auth::user()->hasRole('Admin'))
                        <a onclick="showModal('{{ url('/admin/user/create-user') }}', 'Tambah User Baru')" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah {{ ucfirst($jenis) }} 
                        </a>
                        @endif
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
                        <div class="card">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="studentTable" class="table table-striped table-hover">
                                    <thead>
                                            <tr>
                                                <th class="h6 text-gray-300" style="width: 5px;">No</th>
                                                <th class="h6 text-gray-300">Nama</th>
                                                <th class="h6 text-gray-300">Email</th>
                                                @if(Auth::user()->hasRole('Admin'))
                                                    <th class="h6 text-gray-300">Aksi</th>
                                                @endif
                                            </tr>
                                    </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $loop->iteration }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="flex-align gap-8">
                                                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->nama }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->email }}</span>
                                                    </td>
                                                    @if(Auth::user()->hasRole('Admin'))
                                                        <td>
                                                            <button onclick="showModal('/admin/user/detail/{{ $user->id }}', 'Data Detail {{ ucfirst($jenis) }}')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm"><i class="ph ph-eye btn-icon"></i></buttin>
                                                            <button onclick="deleteUser('{{ $user->id }}', '{{ $jenis }}')" class="btn btn-danger btn-add btn-sm"><i class="ph ph-trash btn-icon"></i></button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteUser(id, jenis) {
            confirmModal('Apakah kamu yakin ingin hapus user ini?', function (){
                ajxProcess('/admin/user/delete-user/' + id + '/' + jenis, {
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                }, '#message-modal')
            });
        }

    $(document).ready(function () {

        initDataTable('#studentTable');

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
