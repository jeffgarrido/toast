@extends('layouts.student')

@section('addhead')
@endsection

@section('content')
    @section('dropdown')
        @foreach($organizations as $organization)
            <p>{{$organization->Description}}</p>
        @endforeach
    @endsection
@endsection