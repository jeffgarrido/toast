@extends('studentpages.layout.studentLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-connectdevelop"></i>{{$org->Description}} <small>({{$status}})</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-users"></i> My Organization
                        </li>
                        <li class="active">
                            <i class="fa fa-connectdevelop"></i> {{$org->Organization_Name}}
                        </li>
                    </ol>
                </div>
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Announcements</a></li>
                        <li><a href="#eventss" data-toggle="tab" aria-expanded="true">Events</a></li>
                        <li><a href="#memberss" data-toggle="tab" aria-expanded="true">Members</a></li>
                        <li><a href="#staff" data-toggle="tab" aria-expanded="true">Staff</a></li>
                    </ul>
                </div>
            </div><!-- row -->
            <div id="myTabContent" class="tab-content">
                <div class="col-lg-12 tab-pane fade active in" id="home">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Announcements
                        </h3>
                    </div>
                    @foreach($announcements as $announcement)
                        <div class="col-lg-12 row row-eq-height" style="margin-bottom: auto">
                            <div class="well well-sm col-lg-10" >
                                <strong><h4>{{$announcement->Title}}</h4></strong>
                                <p><font size="2">Date posted: {{date('F d, Y', strtotime($announcement->created_at))}}</font></p>
                                <hr>
                                <p>Content: {{$announcement->Announcement}}</p>
                            </div>
                            <div class="well well-sm col-lg-2" style="height: auto">
                                <p><font size="2">Posted by: {{$announcement->Uploaded_by}}</font></p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="eventss">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Upcoming Events
                        </h3>
                    </div>
                    <div class="col-md-12">
                        @foreach($events->chunk(3) as $eventChunks)
                            <div class="custom-flexbox">
                                @foreach($eventChunks as $event)
                                    @if ($event->Event_Date > date_format(new DateTime(), 'Y-m-d'))
                                        <div class="col-lg-4">
                                            <div class="panel panel-primary text-center flex-content" style="position: relative; overflow: hidden">
                                                <div class="panel-heading" style="min-height: 60px; max-height: 60px;"><h4>{{ $event->Event_Name }}</h4></div>
                                                <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                                                    <p id="test">Venue : {{ $event->Venue }}</p>
                                                    <p>Date : {{ $event->Event_Date }}</p>
                                                    <p>From : {{ $event->Start_Time }}</p>
                                                    <p>To : {{ $event->End_Time }}</p>
                                                    <p>{{ $event->Description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Past Events
                        </h3>
                    </div>
                    <div class="col-md-12">
                        @foreach($events->chunk(3) as $eventChunks)
                            <div class="custom-flexbox">
                                @foreach($eventChunks as $event)
                                    @if ($event->Event_Date < date_format(new DateTime(), 'Y-m-d'))
                                        <div class="col-lg-4">
                                            <div class="panel panel-danger text-center flex-content" style="position: relative; overflow: hidden">
                                                <div class="panel-heading" style="min-height: 60px; max-height: 60px;"><h4>{{ $event->Event_Name }}</h4></div>
                                                <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                                                    <p id="test">Venue : {{ $event->Venue }}</p>
                                                    <p>Date : {{ $event->Event_Date }}</p>
                                                    <p>From : {{ $event->Start_Time }}</p>
                                                    <p>To : {{ $event->End_Time }}</p>
                                                    <p>{{ $event->Description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="memberss">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Members
                        </h3>
                    </div>
                    <div class="col-lg-12">
                        <table id="memberList" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="hide-column">Id</th>
                                <th>No.</th>
                                <th>Student Number</th>
                                <th>Name</th>
                                <th>Contact Num</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($students as $student)
                                <tr>
                                    <td class="hide-column">{{ $student->Student_Id }}</td>
                                    <td>{{$count++}}</td>
                                    <td>{{ $student->StudentNumber }}</td>
                                    <td>{{ $student->LastName }}, {{ $student->FirstName }}</td>
                                    <td>{{ $student->Phone }}</td>
                                    <td>{{ $student->PersonalEmail }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                $('#memberList').DataTable();
                            } );
                        </script>
                    </div>
                </div>
                <div class="tab-pane fade" id="staff">
                    <div class="col-lg-12" style="margin-top: -2ch">
                        <h3 class="page-header">
                            Staff Members
                        </h3>
                    </div>
                    <div class="col-lg-5" >
                        <div class="well well-sm">
                            <strong>Organization Adviser:</strong> {{$org->professors->FirstName}} {{$org->professors->MiddleName}} {{$org->professors->LastName}}
                        </div>

                        <div class="well well-sm">
                            <strong>President: </strong>@foreach($students as $student)@if($student->pivot->Position == 'President') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                        </div>
                        <div class="well well-sm">
                            <strong>Vice President: </strong>@foreach($students as $student)@if($student->pivot->Position == 'Vice President') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                        </div>
                        <div class="well well-sm">
                            <strong>Treasurer: </strong> @foreach($students as $student)@if($student->pivot->Position == 'Treasurer') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                        </div>
                        <div class="well well-sm">
                            <strong>Secretary: </strong>@foreach($students as $student)@if($student->pivot->Position == 'Secretary') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

@endsection

@section('organizations')
    @foreach($organizations as $organization)
        <li>
            <a href="/organizations/{{$organization->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$organization->Organization_Name}}</a>
        </li>
    @endforeach
@endsection