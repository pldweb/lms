@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Hasil Kuis: {{ $hasil->kuis->judul }}</h4>
                    <a href="{{ url('/siswa/kuis') }}" class="btn btn-secondary">url()->previous()</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Informasi Kuis</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%">Judul Kuis</td>
                                            <td width="5%">:</td>
                                            <td>{{ $hasil->kuis->judul }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelas</td>
                                            <td>:</td>
                                            <td>{{ $hasil->tugas->kelas->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Waktu Mulai</td>
                                            <td>:</td>
                                            <td>{{ \Carbon\Carbon::parse($hasil->waktu_mulai)->format('d M Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Waktu Selesai</td>
                                            <td>:</td>
                                            <td>{{ \Carbon\Carbon::parse($hasil->waktu_selesai)->format('d M Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Durasi Pengerjaan</td>
                                            <td>:</td>
                                            <td>{{ \Carbon\Carbon::parse($hasil->waktu_selesai)->diffForHumans(\Carbon\Carbon::parse($hasil->waktu_mulai), true) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Hasil Pengerjaan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 text-center mb-3">
                                            <div class="display-4 font-weight-bold">
                                                {{ $hasil->nilai_total }}
                                            </div>
                                            <div>Nilai Total</div>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Benar</td>
                                                    <td>:</td>
                                                    <td><span class="badge badge-success">{{ $hasil->jumlah_benar }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Salah</td>
                                                    <td>:</td>
                                                    <td><span class="badge badge-danger">{{ $hasil->jumlah_salah }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Tidak Dijawab</td>
                                                    <td>:</td>
                                                    <td><span class="badge badge-warning">{{ $hasil->jumlah_tidak_dijawab }}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($tampilkanHasil)
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Detail Jawaban</h5>
                            </div>
                            <div class="card-body">
                                @if(count($jawabanSiswa) > 0)
                                    @foreach($jawabanSiswa as $index => $jawaban)
                                        <div class="card mb-3">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Soal {{ $index + 1 }}</h6>
                                                <span class="badge {{ $jawaban->is_benar ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $jawaban->is_benar ? 'Benar' : 'Salah' }}
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="pertanyaan mb-3">
                                                    <strong>Pertanyaan:</strong>
                                                    <div>{!! $jawaban->pertanyaan->pertanyaan !!}</div>

                                                    @if($jawaban->pertanyaan->gambar)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/kuis/' . $jawaban->pertanyaan->gambar) }}"
                                                                alt="Gambar Soal" class="img-fluid" style="max-height: 200px;">
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="jawaban-anda mb-3">
                                                    <strong>Jawaban Anda:</strong>
                                                    <div>
                                                        @if($jawaban->pertanyaan->tipe == 'pilihan_ganda' || $jawaban->pertanyaan->tipe == 'benar_salah')
                                                            @if($jawaban->jawaban)
                                                                {!! $jawaban->jawaban->jawaban !!}
                                                            @else
                                                                <span class="text-muted">Tidak menjawab</span>
                                                            @endif
                                                        @else
                                                            @if($jawaban->jawaban_teks)
                                                                {{ $jawaban->jawaban_teks }}
                                                            @else
                                                                <span class="text-muted">Tidak menjawab</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($jawaban->pertanyaan->tipe != 'esai')
                                                    <div class="jawaban-benar">
                                                        <strong>Jawaban Benar:</strong>
                                                        <div>
                                                            @if($jawaban->pertanyaan->tipe == 'pilihan_ganda' || $jawaban->pertanyaan->tipe == 'benar_salah')
                                                                @php
                                                                    $jawabanBenar = \App\Models\JawabanKuis::where('pertanyaan_id', $jawaban->pertanyaan->id)
                                                                        ->where('is_benar', true)
                                                                        ->first();
                                                                @endphp
                                                                @if($jawabanBenar)
                                                                    {!! $jawabanBenar->jawaban !!}
                                                                @else
                                                                    <span class="text-muted">Tidak ada jawaban benar</span>
                                                                @endif
                                                            @elseif($jawaban->pertanyaan->tipe == 'isian')
                                                                @php
                                                                    $jawabanBenar = \App\Models\JawabanKuis::where('pertanyaan_id', $jawaban->pertanyaan->id)
                                                                        ->where('is_benar', true)
                                                                        ->first();
                                                                @endphp
                                                                @if($jawabanBenar)
                                                                    {{ $jawabanBenar->jawaban }}
                                                                @else
                                                                    <span class="text-muted">Tidak ada jawaban benar</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="nilai mt-2">
                                                    <strong>Nilai:</strong> {{ $jawaban->nilai }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        Tidak ada jawaban yang tersimpan.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            Detail jawaban tidak ditampilkan berdasarkan pengaturan kuis.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
