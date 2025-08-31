@extends('layouts.landing')
@section('title', $title ?? 'Guru dan Pegawai SMP Negeri 20 Jakarta')
@section('description', 'Kenali para guru dan pegawai SMP Negeri 20 Jakarta. Tenaga pendidik dan kependidikan yang profesional dan berdedikasi untuk pendidikan berkualitas.')
@section('keywords', 'guru SMP Negeri 20 Jakarta, pegawai sekolah, tenaga pendidik, profil guru, staf sekolah')
@section('og_image', asset('img/' . ($informasiSekolah->logo ?? 'Logo-SMPN20.png')))

@section('content')
<section class="space-bottom bg-light py-5">
    <div class="container">
        <div class="title-area text-center wow fadeInUp" data-wow-delay="0.3s">
            <div class="sec-icon">
                <img src="{{ asset('img/logo-SMPN20.png') }}" alt="">
            </div>
            <h2 class="sec-title">Guru Dan Pegawai</h2>
            <p class="sec-text">Daftar Guru dan Pegawai di SMP Negeri 199 Jakarta Timur</p>
        </div>

        <div class="row mt-4 justify-content-center">
            <!-- Guru dan Pegawai -->
            @forelse($guruPegawai as $guru)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card team-card h-100 border-0 shadow-sm">
                    <div class="card-img-top overflow-hidden" style="height: 250px;">
                        @if($guru->foto_profile)
                            <img src="{{ asset('storage/' . $guru->foto_profile) }}" alt="{{ $guru->nama }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('landing/img/team/default-profile.svg') }}" alt="{{ $guru->nama }}" class="w-100 h-100" style="object-fit: cover;">
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">{{ $guru->nama }}</h5>
                        <p class="text-muted small mb-2">Guru</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada data guru dan pegawai</p>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $guruPegawai->links() }}
        </div>
    </div>
</section>
@endsection