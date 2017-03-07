@extends('layouts.student')

@section('addhead')
@endsection

@section('content')

    @section('dropdown')
        @foreach($organizations as $organization)
            <p>{{$organization->Description}}</p>
        @endforeach
    @endsection

    <div class="container">
        <div class="col-lg-4">
            <div class="card card-primary text-center z-depth-2">
                <div class="card-block">
                    <p class="white-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                </div>
            </div>
        </div>
    </div>

@endsection