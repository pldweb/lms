@extends('layouts.landing')
@section('title', $title)
@section('content')
    
    @include('landing.components.hero')

    @include('landing.components.count-school')

    @include('landing.components.category')

    @include('landing.components.cta')

    {{-- <div data-bg-src="{{asset('landing/img/bg/course-bg-pattern.jpg')}}">
    </div> --}}

    @include('landing.components.artikel')
    
@endsection