@extends('layouts.admin')
@section('content')

{{ Auth::user()->roles->first()->name }}
<h1>{{Auth::user()->nama}}</h1>
<h1>{{Auth::user()->email}}</h1>
    
@endsection