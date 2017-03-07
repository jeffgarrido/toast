@extends('layouts.student')

@section('addhead')
@endsection

@section('content')

    @foreach($organizations as $organization)
        <p>{{$organization->Description}}</p>
    @endforeach

@endsection