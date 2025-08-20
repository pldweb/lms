@extends('layouts.admin')
@section('title', 'Log Aktivitas')
@section('content')
    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <table class="table table-striped table-hover" id="table-log-aktivitas">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">No</th>
                                            <th class="h6 text-gray-300">Aktivitas</th>
                                            <th class="h6 text-gray-300">Waktu</th>
                                            <th class="h6 text-gray-300">User Agent</th>
                                            <th class="h6 text-gray-300">IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logAktivitas as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->aktivitas }}</td>
                                                <td>{{ $item->waktu }}</td>
                                                <td>{{ $item->user_agent }}</td>
                                                <td>{{ $item->ip_address }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                $('#table-log-aktivitas tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
                });
            });

            $('#table-log-aktivitas').DataTable({
                paging: true,
                lengthChange: true,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [0] } 
                ]
            });
        });

        
    </script>
@endsection
