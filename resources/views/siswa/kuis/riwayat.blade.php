@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Riwayat Kuis</h4>
                    <a href="{{ url('/siswa/kuis') }}" class="btn btn-secondary">url()->previous()</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(count($hasilKuis) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Kelas</th>
                                        <th width="25%">Judul Kuis</th>
                                        <th width="15%">Tanggal Pengerjaan</th>
                                        <th width="10%">Nilai</th>
                                        <th width="15%">Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hasilKuis as $key => $item)
                                        <tr>
                                            <td>{{ $hasilKuis->firstItem() + $key }}</td>
                                            <td>{{ $item->tugas->kelas->nama }}</td>
                                            <td>{{ $item->kuis->judul }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M Y') }}</td>
                                            <td>{{ $item->nilai_total }}</td>
                                            <td>
                                                @php
                                                    $statusClass = 'badge-info';
                                                    if ($item->nilai_total >= 80) {
                                                        $statusClass = 'badge-success';
                                                    } elseif ($item->nilai_total >= 60) {
                                                        $statusClass = 'badge-warning';
                                                    } elseif ($item->nilai_total < 60) {
                                                        $statusClass = 'badge-danger';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ url('/siswa/kuis/hasil/' . $item->id) }}" class="btn btn-sm btn-info">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $hasilKuis->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Belum ada riwayat pengerjaan kuis.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
