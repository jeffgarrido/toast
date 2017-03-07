@extends('layouts.student')

@section('addhead')
    <script>
        $(document).ready(function(){
            $('#membersTable').dataTable( );
        });
    </script>
@endsection

@section('content')

    @section('dropdown')
        @foreach($organizations as $organization)
            <li><a href="/my_organization/{{$organization->Organization_Id}}">{{$organization->Description}}</a></li>
        @endforeach
    @endsection
<div class="container-fluid">
    <div class="col-md-3">
        <div class="nav-side-menu">
            <div class="brand"><b>My Organizations</b></div>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

            <div class="menu-list">

                <ul id="menu-content" class="menu-content collapse out" style="text-align: center">
                    @foreach($organizations as $organization)
                        <li><a href="/my_organization/{{$organization->Organization_Id}}"><i class="fa fa-dashboard fa-lg">{{$organization->Organization_Name}}</i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9 container-fluid event"  style="margin-top: -5ch">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{$orgs->Description}}
                </h1>
            </div>
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#events" data-toggle="tab" aria-expanded="true">Events</a></li>
                    <li class=""><a href="#announcement" data-toggle="tab" aria-expanded="true">Announcements</a></li>
                    <li class=""><a href="#members" data-toggle="tab" aria-expanded="true">Members</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="events">
                        @foreach($events as $event)
                            <div class="col-md-4" style="margin-top: 3ch">
                                <div class="panel panel-primary stylish-panel text-center flex-content" style="position: relative; overflow: hidden">
                                    <div>
                                        <div class="panel-heading events" style="min-height: 60px; max-height: 60px;"><b>{{ $event->Event_Name }}</b></div>
                                        <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                                            <p id="test">Venue : {{ $event->Venue }}</p>
                                            <p>From : {{ $event->Start_Time }}</p>
                                            <p>To : {{ $event->End_Time }}</p>
                                            <p>{{ $event->Description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="announcement">
                        <h1>announcement area</h1>
                    </div>
                    <div class="tab-pane fade" id="members" style="margin-top: 3ch">
                        <table id="membersTable" class="table display compact table-condensed table-responsive" width="100%" cellspacing="0">
                            {{$count = 1}}
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Student Number</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td>{{ $student->StudentNumber }}</td>
                                    <td>{{ $student->LastName }}, {{ $student->FirstName }} {{ $student->MiddleName }}</td>
                                    <td>{{ $student->PersonalEmail }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
