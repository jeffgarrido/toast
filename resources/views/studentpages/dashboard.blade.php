@extends('layouts.student')

@section('content')

    @section('dropdown')
        @foreach($organizations as $organization)
            <li><a href="/my_organization/{{$organization->Organization_Id}}">{{$organization->Description}}</a></li>
        @endforeach
    @endsection

@endsection