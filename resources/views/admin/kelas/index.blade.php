@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Manajemen Kelas</h1>
                </div>
                <div>
                    <a href="/admin/kelas/create" class="btn btn-primary btn-sm">
                        <i class="ph ph-plus"></i> Tambah Kelas
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ph ph-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ph ph-warning-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter Card -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="GET" action="{{ url('/admin/kelas') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" placeholder="Cari nama, kode kelas..." value="{{ request('search') }}">
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
                                            <a href="{{ url('/admin/kelas') }}" class="btn btn-secondary btn-sm">
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
                                    <table class="table table-striped table-hover" id="table-kelas" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="h6 text-gray-300">No</th>
                                                <th class="h6 text-gray-300">Kode</th>
                                                <th class="h6 text-gray-300">Nama Kelas</th>
                                                <th class="h6 text-gray-300">Jenjang</th>
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
                                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $kls->jenjang }}</span></td>
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
                                                    <div class="btn-group" role="group" aria-label="Aksi">
                                                        {{-- Detail Kelas --}}
                                                        <a href="/admin/kelas/show/{{ $kls->id }}" class="btn btn-primary btn-sm btn-add" title="Detail">
                                                            <i class="ph ph-eye btn-icon"></i>
                                                        </a>
                                                        {{-- Edit Kelas --}}
                                                        <a href="/admin/kelas/edit/{{ $kls->id }}" class="btn btn-warning btn-sm btn-add" title="Edit">
                                                            <i class="ph ph-pencil btn-icon"></i>
                                                        </a>

                                                        {{-- Delete Kelas --}}
                                                        <button type="button" class="btn btn-danger btn-sm btn-add" title="Hapus" onclick="confirmDelete({{ $kls->id }})">
                                                            <i class="ph ph-trash btn-icon"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data kelas</td>
                                            </tr>
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
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            let keyword = $(this).val().toLowerCase();
            $('#table-kelas tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
            });
        });

        // Export Data (CSV / JSON)
        $('#exportOptions').on('change', function () {
            const format = $(this).val();
            const $table = $('#table-kelas');
            const headers = [];
            const data = [];

            // Get headers
            $table.find('thead th').each(function () {
                headers.push($(this).text().trim());
            });

            // Get data
            $table.find('tbody tr').each(function () {
                const row = [];
                $(this).find('td').each(function () {
                    row.push($(this).text().trim());
                });
                data.push(row);
            });

            if (format === 'csv') {
                downloadCSV(headers, data, 'kelas.csv');
            } else if (format === 'json') {
                downloadJSON(headers, data, 'kelas.json');
            }
        });
    });

    function downloadCSV(headers, data, filename) {
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += headers.join(",") + "\n";
        data.forEach(function(rowArray) {
            let row = rowArray.join(",");
            csvContent += row + "\n";
        });
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function downloadJSON(headers, data, filename) {
        const jsonData = data.map(row => {
            const obj = {};
            headers.forEach((header, index) => {
                obj[header] = row[index];
            });
            return obj;
        });
        
        const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(jsonData, null, 2));
        const link = document.createElement("a");
        link.setAttribute("href", dataStr);
        link.setAttribute("download", filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/kelas/delete/' + id;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection
