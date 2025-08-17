@extends('layouts.admin')

@section('title', 'Detail Tahun Ajaran')

@section('content')
<div class="container-fluid mt-10">
    <div class="d-sm-flex align-items-center justify-content-between mb-10">
        <h1 class="h3 mb-0 text-gray-800">Detail Tahun Ajaran</h1>
    </div>

    <div class="row">
        <!-- Detail Tahun Ajaran -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header b-title py-3 mt-10">
                    <h5 class="m-0 font-weight-bold text-gray-300">Informasi Tahun Ajaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Nama Tahun Ajaran</strong></td>
                            <td>: {{ $tahunAjaran->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Mulai</strong></td>
                            <td>: {{ date('d F Y', strtotime($tahunAjaran->tanggal_mulai)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Selesai</strong></td>
                            <td>: {{ date('d F Y', strtotime($tahunAjaran->tanggal_selesai)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @if($tahunAjaran->status === 'aktif')
                                    <span class="badge bg-success badge-lg">Aktif</span>
                                @else
                                    <span class="badge bg-secondary badge-lg">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Durasi</strong></td>
                            <td>: 
                                @php
                                    $start = new DateTime($tahunAjaran->tanggal_mulai);
                                    $end = new DateTime($tahunAjaran->tanggal_selesai);
                                    $interval = $start->diff($end);
                                    $days = $interval->days;
                                    $months = floor($days / 30);
                                @endphp
                                {{ $days }} hari (± {{ $months }} bulan)
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Keterangan</strong></td>
                            <td>: {{ $tahunAjaran->keterangan ?: 'Tidak ada keterangan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>: {{ date('d F Y H:i', strtotime($tahunAjaran->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui</strong></td>
                            <td>: {{ date('d F Y H:i', strtotime($tahunAjaran->updated_at)) }}</td>
                        </tr>
                    </table>
                    <div>
                        <a href="/admin/tahun-ajaran/edit/{{ $tahunAjaran->id }}" class="d-none d-sm-inline-block btn btn-sm btn-primary">
                            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                        </a>
                        <a href="/admin/tahun-ajaran/" class="d-none d-sm-inline-block btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                        </a>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-danger" onclick="deleteTahunAjaran('{{ $tahunAjaran->id }}')">
                             Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="col-md-4">
            <div class="card mb-20">
                <div class="card-header py-3 mt-10 b-title">
                    <h5 class="m-0 font-weight-bold text-gray-300">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <h4 class="text-primary">{{ $jumlahKelas }}</h4>
                            <small class="text-muted">Total Kelas</small>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-success">{{ $jumlahSiswa }}</h4>
                            <small class="text-muted">Total Siswa Terdaftar</small>
                        </div>
                        <hr>
                        @if($tahunAjaran->status !== 'aktif')
                            <button class="btn btn-success btn-block" onclick="activateTahunAjaran('{{ $tahunAjaran->id }}')">Aktifkan Tahun Ajaran</button>
                        @else
                            <div class="alert alert-success text-center">
                                <strong>Tahun Ajaran Aktif</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="card mb-4">
                <div class="card-header b-title py-3 mt-10">
                    <h6 class="m-0 font-weight-bold text-gray-300">Timeline</h6>
                </div>
                <div class="card-body">
                    @php
                        $now = now();
                        $start = new DateTime($tahunAjaran->tanggal_mulai);
                        $end = new DateTime($tahunAjaran->tanggal_selesai);
                        $current = new DateTime();
                    @endphp
                    
                    @if($current < $start)
                        <div class="text-center">
                            <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                            <h6 class="text-warning">Belum Dimulai</h6>
                            <small class="text-muted">
                                Akan dimulai {{ $start->diff($current)->days }} hari lagi
                            </small>
                        </div>
                    @elseif($current >= $start && $current <= $end)
                        <div class="text-center">
                            <i class="fas fa-play-circle text-success fa-2x mb-2"></i>
                            <h6 class="text-success">Sedang Berlangsung</h6>
                            <small class="text-muted">
                                @php
                                    $progress = $start->diff($current)->days;
                                    $total = $start->diff($end)->days;
                                    $percentage = $total > 0 ? round(($progress / $total) * 100) : 0;
                                @endphp
                                Progress: {{ $percentage }}% ({{ $progress }}/{{ $total }} hari)
                            </small>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fas fa-check-circle text-info fa-2x mb-2"></i>
                            <h6 class="text-info">Selesai</h6>
                            <small class="text-muted">
                                Berakhir {{ $current->diff($end)->days }} hari yang lalu
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteTahunAjaran(id){
        confirmModal('Yakin ingin menghapus tahun ajaran ini?', function(){
            ajxProcess('/admin/tahun-ajaran/delete/' + id, null, '#message-modal');
        });
    }

    function activateTahunAjaran(id){
        confirmModal('Yakin ingin mengaktifkan tahun ajaran ini?', function(){
            ajxProcess('/admin/tahun-ajaran/activate/' + id, null, '#message-modal');
        });
    }
</script>
@endsection
