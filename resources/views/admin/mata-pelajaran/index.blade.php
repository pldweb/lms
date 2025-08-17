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

                <!-- Filter Card -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="GET" action="{{ url('/admin/mata-pelajaran') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama, kode, atau deskripsi..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="jenjang" class="form-control">
                                        <option value="">Semua Jenjang</option>
                                        <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="SMK" {{ request('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="semester" class="form-control">
                                        <option value="">Semua Semester</option>
                                        <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                                        <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                     <select name="aktif" class="form-control">
                                         <option value="">Semua Status</option>
                                         <option value="1" {{ request('aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                                         <option value="0" {{ request('aktif') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                     </select>
                                 </div>
                                <div class="col-md-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="ph ph-magnifying-glass"></i> Filter
                                        </button>
                                        <a href="{{ url('/admin/mata-pelajaran') }}" class="btn btn-secondary btn-sm">
                                            <i class="ph ph-x"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-body">
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
                                                <th class="h6 text-gray-300">Status</th>
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
                                                    @if($mp->aktif)
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
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data mata pelajaran</td>
                                            </tr>
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
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            let keyword = $(this).val().toLowerCase();
            $('#table-mata-pelajaran tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
            });
        });

        // Export Data (CSV / JSON)
        $('#exportOptions').on('change', function () {
            const format = $(this).val();
            const $table = $('#table-mata-pelajaran');
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
            a.download = 'mata-pelajaran.csv';
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
            a.download = 'mata-pelajaran.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });

    function confirmDelete(id) {
        confirmModal('Yakin ingin menghapus mata pelajaran ini?', function(){
            ajxProcess('/admin/mata-pelajaran/delete-action/' + id, null, '#message-modal');
        });
    }


</script>
@endsection
