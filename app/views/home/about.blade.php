@extends('layouts.master')

@section('content')
    hello
@stop

@if($user)
    <p>{{ $user}}</p>
@endif

