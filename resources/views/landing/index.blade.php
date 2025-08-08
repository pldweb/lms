@extends('layouts.landing')
@section('title', $title)
@section('content')
    
    <!--============================== Hero Area ==============================-->
    @include('landing.components.hero')

    <!--============================== About Area ==============================-->
    @include('landing.components.about')
    
    <!--============================== Category Area ==============================-->
    @include('landing.components.category')

    <!--============================== CTA Area ==============================-->
    <div data-bg-src="{{asset('landing/img/bg/course-bg-pattern.jpg')}}">
        @include('landing.components.cta')
    </div>

    <!--============================== Artikel ==============================-->
    @include('landing.components.artikel')
    
@endsection