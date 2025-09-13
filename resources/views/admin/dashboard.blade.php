@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')


<div class="div">
    <div class="row mb-4">
                    <!-- Total Buku -->
                    <div class="col-md-3">
                        <div class="card" style="background: linear-gradient(135deg, #2563EB, #1E40AF); color: white;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white">Total Siswa</h6>
                                        <h2 class="mb-0 mt-2 text-white">200</h2>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="ph ph-trend-up me-1"></i>
                                            <small>250</small>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="ph ph-book-open" style="font-size: 32px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota Aktif -->
                    <div class="col-md-3">
                        <div class="card" style="background: linear-gradient(135deg, #10B981, #047857); color: white;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white">Total Guru</h6>
                                        <h2 class="mb-0 mt-2 text-white">4</h2>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="ph ph-trend-up me-1"></i>
                                            <small>+8 anggota bulan ini</small>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="ph ph-users" style="font-size: 32px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sedang Dipinjam -->
                    <div class="col-md-3">
                        <div class="card" style="background: linear-gradient(135deg, #8B5CF6, #6D28D9); color: white;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white">Total Agenda</h6>
                                        <h2 class="mb-0 mt-2 text-white">2</h2>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="ph ph-calendar me-1"></i>
                                            <small>Hari ini</small>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="ph ph-book" style="font-size: 32px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terlambat -->
                    <div class="col-md-3">
                        <div class="card" style="background: linear-gradient(135deg, #EF4444, #B91C1C); color: white;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white">Total Peminjaman</h6>
                                        <h2 class="mb-0 mt-2 text-white">1</h2>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="ph ph-warning me-1"></i>
                                            <small>Perlu tindakan</small>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="ph ph-warning-circle" style="font-size: 32px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
                

@endsection