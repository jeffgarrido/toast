@extends('layouts.master')

@section('body')
<div class="container">
    <div class="col-md-1"></div>
    <div class="col-md-10 text-center">
        <h1>WELCOME {{ Auth::user()->name }}! SUCCESSFULL LOGIN!</h1>
    </div>
    <div class="col-md-1"></div>

</div>

@endsection
