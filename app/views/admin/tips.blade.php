@extends('layouts.master')
@section('style')
    {{ HTML::style('css/tips.css') }}
@stop
@section('middle')
    <div class="msg">
        <div id="content">
            {{ $msg }}
        </div>
    </div>
@stop