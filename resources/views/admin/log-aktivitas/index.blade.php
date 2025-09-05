@extends('layouts.admin')
@section('title', 'Log Aktivitas')
@section('content')
    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header b-title">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title w-content">Data Log Aktivitas</h3>
                        <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                                <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body relative overflow-x-auto">
                    @if($logAktivitas->isEmpty())
                        {!! alert('Belum ada log aktivitas', 'warning') !!}
                    @else
                    <table class="table table-striped table-hover relative" id="table-log-aktivitas">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300">No</th>
                                <th class="h6 text-gray-300">Aktivitas</th>
                                <th class="h6 text-gray-300">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logAktivitas as $item)
                                    <tr>
                                        <td class="text-gray-400">{{ $item->id}}</td>
                                        <td class="text-gray-400">{{ $item->aktivitas }}</td>
                                        <td class="text-gray-400">{{ $item->waktu_aktivitas }} WIB</td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            initDataTable("#table-log-aktivitas");
        });
    </script>
@endsection
