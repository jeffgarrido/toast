@extends('professor.layout.professorLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-dashboard"></i>Dashboard <small>Statistics Overview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </li>
                    </ol>
                </div>
            </div><!-- row -->

            <div class="row">
                @foreach($outcomes->chunk(4) as $outcomeChunk)
                    <div class="col-lg-12 bottom-pad">
                        @foreach($outcomeChunk as $outcome)
                            <div class="col-lg-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <div class="huge">{{ $outcome->Outcome_Code }}</div>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div>Developing: <span class="badge">{{ $outcome->students->count() }}</span></div>
                                                <div>Events: <span class="badge">{{ $outcome->events->count() }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:;" data-toggle="modal" data-target="#outcomeDetail{{$outcome->Outcome_Id}}">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-o-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!--<editor-fold desc="Modal for Outcome Details">-->
                            <div class="modal fade" id="outcomeDetail{{$outcome->Outcome_Id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <div class="row col-lg-12">
                                                <h2 class="modal-title">
                                                    <span class="fa fa-fw fa-compass" aria-hidden="true"></span> {{ $outcome->Outcome_Code }}
                                                </h2>
                                                <small>{{ $outcome->Description }}</small>
                                            </div>
                                        </div>
                                        <div class="modal-body" style="min-height: 40vh;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <!--<editor-fold desc="P1, P2, P3, Event tabs">-->
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#Students{{ $outcome->Outcome_Id }}" data-toggle="tab" aria-expanded="false">
                                                                Developing <span class="badge">{{ $outcome->students->count() }}</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#Events{{ $outcome->Outcome_Id }}" data-toggle="tab" aria-expanded="false">
                                                                Events <span class="badge">{{ $outcome->events->count() }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div id="myTabContent" class="tab-content">
                                                        <div class="tab-pane fade active in" id="Students{{ $outcome->Outcome_Id }}">
                                                            <div class="bottom-pad"></div>
                                                            <table class="studentTable table table-hover table-condensed table-responsive table-bordered compact" width="100%" cellspacing="0">
                                                                <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Name</th>
                                                                    <th>Contact Number</th>
                                                                    <th>Email</th>
                                                                    <th>Evaluation</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($outcome->students as $student)
                                                                    <tr class="record-details" data-href="/students/{{ $student->Student_Id }}">
                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td>{{$student->LastName}}, {{$student->FirstName}} {{$student->MiddleName}}</td>
                                                                        <td>{{$student->Phone}}</td>
                                                                        <td>{{$student->PersonalEmail}}</td>
                                                                        <th>{{$student->pivot->Evaluation}}</th>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane fade" id="Events{{ $outcome->Outcome_Id }}">
                                                            <div class="bottom-pad"></div>
                                                            <table class="eventsTable table table-hover table-condensed table-responsive table-bordered compact" width="100%" cellspacing="0">
                                                                <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Name</th>
                                                                    <th>Organization</th>
                                                                    <th>Date</th>
                                                                    <th>Time</th>
                                                                    <th>Venue</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($outcome->events as $event)
                                                                    <tr class="record-details" data-href="/events/{{ $event->Event_Id }}">
                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td>{{ $event->Event_Name }}</td>
                                                                        <td>{{ $event->Organization }}</td>
                                                                        <td>{{ $event->Event_Date }}</td>
                                                                        <th>{{ $event->Start_Time }} - {{ $event->End_Time }}</th>
                                                                        <th>{{ $event->Venue }}</th>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!--</editor-fold>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--</editor-fold>-->
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

    <script>
        $(document).ready(function() {
            $('.studentTable').DataTable();
            $('.eventsTable').DataTable();
        } );
    </script>
</div><!-- page-wrapper -->
@endsection

@section('organizations')
    @foreach($professor->organizations as $org)
        <li>
            <a href="/porganization/{{$org->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$org->Organization_Name}}</a>
        </li>
    @endforeach
@endsection