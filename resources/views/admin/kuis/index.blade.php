@extends('layouts.admin')
@section('content')
    <div class="row mt-20 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header b-title d-flex justify-content-between align-items-center">
                    <h4>Manajemen Kuis</h4>
                    <a href="{{ url('/admin/kuis/create') }}" class="btn btn-primary btn-add">Tambah Kuis</a>
                </div>
                <div class="card-body">
                    @if(count($kuis) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Judul</th>
                                        <th width="15%">Pembuat</th>
                                        <th width="10%">Jumlah Soal</th>
                                        <th width="15%">Tanggal Dibuat</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kuis as $key => $item)
                                        <tr>
                                            <td>{{ $kuis->firstItem() + $key }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->pembuat ? $item->pembuat->name : 'N/A' }}</td>
                                            <td>{{ $item->pertanyaan->count() }}</td>
                                            <td>{{ $item->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ url('/admin/kuis/show/' . $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                                                <a href="{{ url('/admin/kuis/edit/' . $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="{{ url('/admin/kuis/pertanyaan/' . $item->id) }}" class="btn btn-sm btn-primary">Soal</a>
                                                <a href="{{ url('/admin/kuis/delete/' . $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kuis ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $kuis->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Belum ada kuis yang tersedia. Silakan tambahkan kuis baru.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection