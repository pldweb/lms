@extends('layouts.admin')
@section('title', 'Daftar Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Daftar Tugas</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/guru/tugas/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Tugas
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
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-group">
                                <label for="kelas_filter">Kelas:</label>
                                <select id="kelas_filter" class="form-select">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }} ({{ $k->tahun_ajaran }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun_ajaran_filter">Tahun Ajaran:</label>
                                <select id="tahun_ajaran_filter" class="form-select">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach ($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="tugasTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="fixed-width">
                                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox" id="selectAll">
                                            </th>
                                            <th class="h6 text-gray-300">Judul</th>
                                            <th class="h6 text-gray-300">Kelas</th>
                                            <th class="h6 text-gray-300">Tenggat Waktu</th>
                                            <th class="h6 text-gray-300">Pengumpulan</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugas as $t)
                                            <tr>
                                                <td class="fixed-width">
                                                    <div class="form-check">
                                                        <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="flex-align gap-8">
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $t->judul }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $t->kelas_nama }}</span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                                        {{ $t->tenggat_waktu ? date('d M Y H:i', strtotime($t->tenggat_waktu)) : 'Tidak ada tenggat' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                                        {{ $t->jumlah_pengumpulan ?? 0 }} pengumpulan
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/guru/tugas/show') }}/{{ $t->id }}" class="btn btn-primary btn-add btn-sm">Detail</a>
                                                    <a href="{{ url('/guru/tugas/edit') }}/{{ $t->id }}" class="btn btn-warning btn-add btn-sm">Edit</a>
                                                    <a href="{{ url('/guru/tugas/delete') }}/{{ $t->id }}" class="btn btn-danger btn-add btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        {{ $tugas->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#tugasTable').DataTable({
            "paging": false,
            "info": false,
            "searching": false
        });

        // Filter kelas
        $('#kelas_filter').change(function() {
            filterData();
        });

        // Filter tahun ajaran
        $('#tahun_ajaran_filter').change(function() {
            filterData();
        });

        // Pencarian
        $('#searchInput').keyup(function(e) {
            if (e.keyCode === 13) {
                filterData();
            }
        });

        // Export data
        $('#exportOptions').change(function() {
            var format = $(this).val();
            if (format) {
                var url = '{{ url("/guru/tugas/export") }}/' + format;
                var kelas_id = $('#kelas_filter').val();
                var tahun_ajaran_id = $('#tahun_ajaran_filter').val();
                var search = $('#searchInput').val();

                var params = [];
                if (kelas_id) params.push('kelas_id=' + kelas_id);
                if (tahun_ajaran_id) params.push('tahun_ajaran_id=' + tahun_ajaran_id);
                if (search) params.push('search=' + encodeURIComponent(search));

                if (params.length > 0) {
                    url += '?' + params.join('&');
                }

                window.location.href = url;
                $(this).val('');
            }
        });

        // Select all checkbox
        $('#selectAll').click(function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });

        // Function untuk filter data
        function filterData() {
            var kelas_id = $('#kelas_filter').val();
            var tahun_ajaran_id = $('#tahun_ajaran_filter').val();
            var search = $('#searchInput').val();

            var url = '{{ url("/guru/tugas") }}';
            var params = [];

            if (kelas_id) params.push('kelas_id=' + kelas_id);
            if (tahun_ajaran_id) params.push('tahun_ajaran_id=' + tahun_ajaran_id);
            if (search) params.push('search=' + encodeURIComponent(search));

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            window.location.href = url;
        }
    });
</script>

@endsection