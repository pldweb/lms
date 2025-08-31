@extends('admin.layouts.app')
@section('title', 'Detail Halaman')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Halaman</h3>
                        <div class="card-tools">
                            <a href="{{ url('/admin/halaman') }}" class="btn btn-secondary btn-add">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ url('/admin/halaman/edit/' . $halaman->id) }}" class="btn btn-primary btn-add">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Judul</th>
                                        <td>{{ $halaman->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>{{ $halaman->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge badge-{{ $halaman->status == 'publish' ? 'success' : 'warning' }}">
                                                {{ $halaman->status == 'publish' ? 'Publish' : 'Draft' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Publish</th>
                                        <td>
                                            @if($halaman->tanggal_publish)
                                                {{ \Carbon\Carbon::parse($halaman->tanggal_publish)->format('d M Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Penulis</th>
                                        <td>{{ $halaman->penulis->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah View</th>
                                        <td>{{ $halaman->views }}</td>
                                    </tr>
                                    <tr>
                                        <th>URL Halaman</th>
                                        <td>
                                            <a href="{{ url('/halaman/' . $halaman->slug) }}" target="_blank">
                                                {{ url('/halaman/' . $halaman->slug) }}
                                                <i class="fas fa-external-link-alt ml-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                @if($halaman->gambar)
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('img/halaman/' . $halaman->gambar) }}" alt="{{ $halaman->judul }}" class="img-fluid rounded">
                                        <p class="mt-2 text-muted">Gambar Halaman</p>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Tidak ada gambar untuk halaman ini
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Konten Halaman</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="content-preview">
                                            {!! $halaman->isi !!}
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
@endsection

@push('styles')
    <style>
        .content-preview {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-height: 300px;
        }
        .content-preview img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush