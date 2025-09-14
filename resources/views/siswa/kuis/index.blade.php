@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Kuis</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif

                    @if(count($tugas) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Kelas</th>
                                        <th width="25%">Judul</th>
                                        <th width="15%">Tenggat Waktu</th>
                                        <th width="15%">Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tugas as $key => $item)
                                        <tr>
                                            <td>{{ $tugas->firstItem() + $key }}</td>
                                            <td>{{ $item->kelas->nama }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>
                                                @if($item->tenggat_waktu)
                                                    {{ \Carbon\Carbon::parse($item->tenggat_waktu)->format('d M Y H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $now = \Carbon\Carbon::now();
                                                    $status = 'Tersedia';
                                                    $statusClass = 'badge-success';
                                                    
                                                    // Cek apakah kuis sudah pernah dikerjakan
                                                    $hasilKuis = \App\Models\HasilKuis::where('siswa_id', Auth::id())
                                                        ->where('tugas_id', $item->id)
                                                        ->where('kuis_id', $item->kuis_id)
                                                        ->where('status', 'selesai')
                                                        ->first();
                                                    
                                                    if ($hasilKuis) {
                                                        $status = 'Sudah Dikerjakan';
                                                        $statusClass = 'badge-info';
                                                    } elseif ($item->waktu_mulai && $now->lt(\Carbon\Carbon::parse($item->waktu_mulai))) {
                                                        $status = 'Belum Dimulai';
                                                        $statusClass = 'badge-warning';
                                                    } elseif ($item->waktu_selesai && $now->gt(\Carbon\Carbon::parse($item->waktu_selesai))) {
                                                        $status = 'Sudah Berakhir';
                                                        $statusClass = 'badge-danger';
                                                    } elseif ($item->tenggat_waktu && $now->gt(\Carbon\Carbon::parse($item->tenggat_waktu))) {
                                                        $status = 'Terlambat';
                                                        $statusClass = 'badge-danger';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                            </td>
                                            <td>
                                                @if($hasilKuis)
                                                    <a href="{{ url('/siswa/kuis/hasil/' . $hasilKuis->id) }}" class="btn btn-sm btn-info">Lihat Hasil</a>
                                                @else
                                                    @if(($item->waktu_mulai && $now->lt(\Carbon\Carbon::parse($item->waktu_mulai))) || 
                                                       ($item->waktu_selesai && $now->gt(\Carbon\Carbon::parse($item->waktu_selesai))))
                                                        <button class="btn btn-sm btn-secondary" disabled>Kerjakan</button>
                                                    @else
                                                        <a href="{{ url('/siswa/kuis/mulai/' . $item->id) }}" class="btn btn-sm btn-primary">Kerjakan</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $tugas->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Belum ada kuis yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection