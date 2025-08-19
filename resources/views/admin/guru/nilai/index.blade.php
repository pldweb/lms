@extends('layouts.admin')
@section('title', 'Daftar Nilai')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Daftar Nilai</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ url('/guru/nilai') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari siswa atau tugas..." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ph ph-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" placeholder="Nilai Min" name="min_score" value="{{ request('min_score') }}" min="0" max="100">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" placeholder="Nilai Max" name="max_score" value="{{ request('max_score') }}" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-funnel"></i> Filter
                                    </button>
                                    <a href="{{ url('/guru/nilai') }}" class="btn btn-secondary">
                                        <i class="ph ph-arrow-counter-clockwise"></i>
                                    </a>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ph ph-export"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ url('/guru/nilai/export/csv' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')) }}">Export CSV</a></li>
                                        <li><a class="dropdown-item" href="{{ url('/guru/nilai/export/json' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')) }}">Export JSON</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Judul Tugas</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Tanggal Penilaian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($nilai) > 0)
                                @foreach($nilai as $index => $n)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $n->pengumpulanTugas->siswa->name }}</td>
                                        <td>{{ $n->pengumpulanTugas->tugas->judul }}</td>
                                        <td>{{ $n->pengumpulanTugas->tugas->kelas->nama }}</td>
                                        <td><span class="badge bg-primary">{{ $n->skor }}</span></td>
                                        <td>{{ date('d M Y H:i', strtotime($n->dinilai_pada)) }}</td>
                                        <td>
                                            <a href="{{ url('/guru/nilai/show/' . $n->id) }}" class="btn btn-info btn-sm">
                                                <i class="ph ph-eye"></i> Detail
                                            </a>
                                            <a href="{{ url('/guru/nilai/edit/' . $n->id) }}" class="btn btn-warning btn-sm">
                                                <i class="ph ph-pencil"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data nilai</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $nilai->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection