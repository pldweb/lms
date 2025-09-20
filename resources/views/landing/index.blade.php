@extends('layouts.landing')
@section('title', $title)
@section('description', $informasiSekolah->tagline ?? 'SMP Negeri 20 Jakarta - Sekolah Menengah Pertama Negeri di Jakarta yang mengutamakan pendidikan berkualitas dan pengembangan karakter siswa.')
@section('keywords', 'SMP Negeri 20 Jakarta, Sekolah Menengah Pertama, Pendidikan, Jakarta, Sekolah Negeri')
@section('og_image', logo_utama())  
@section('content')
    
    @include('landing.components.hero')

    @include('landing.components.count-school')

    @include('landing.components.category')

    @include('landing.components.guru-pegawai')

    {{-- @include('landing.components.cta') --}}

    {{-- <div data-bg-src="{{asset('landing/img/bg/course-bg-pattern.jpg')}}">
    </div> --}}

    @include('landing.components.artikel-new')
    
@endsection