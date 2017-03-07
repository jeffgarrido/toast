@extends('layouts.student')

@section('addhead')
@endsection

@section('content')

    @section('dropdown')
        @foreach($organizations as $organization)
            <li><a href="#">{{$organization->Description}}</a></li>
            <li class="divider"></li>
        @endforeach
    @endsection
<div class="container-fluid">
<div class="col-md-3">
    <div class="nav-side-menu">
        <div class="brand">{{$orgs->Organization_Name}}</div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">

            <ul id="menu-content" class="menu-content collapse out">
                <li class="getProfessorList">
                    <a href="#list">
                        <i class="fa fa-dashboard fa-lg glyphicon glyphicon-user"></i> Professor List
                    </a>
                </li>
                <script>
                    $('.getProfessorList').click(function(){
                        $('.loading-div').show();
                        getProfessorList();
                    });
                </script>
                <li class="getProfAndSubject">
                    <a href="#">
                        <i class="fa fa-dashboard fa-lg glyphicon glyphicon-plus-sign"></i> Assign Subject
                    </a>
                </li>
                <script>
                    $('.getProfAndSubject').click(function(){
                        $('.loading-div').show();
                        getProfAndSubject();

                    });
                </script>
            </ul>
        </div>
    </div>
</div>
<div class="col-md-9 container-fluid" id="proflist" style="overflow-y: hidden">
            @foreach($events as $event)
                <div class="col-md-4">
                    <div class="panel panel-primary text-center flex-content" style="position: relative; overflow: hidden">
                        <div class="panel-heading events" style="min-height: 60px; max-height: 60px;">{{ $event->Event_Name }}</div>
                        <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                            <p id="test">Venue : {{ $event->Venue }}</p>
                            <p>From : {{ $event->Start_Time }}</p>
                            <p>To : {{ $event->End_Time }}</p>
                            <p>{{ $event->Description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

</div>
</div>

















@endsection