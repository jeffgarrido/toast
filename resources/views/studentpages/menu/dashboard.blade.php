@extends('studentpages.layout.studentLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-child"></i>{{ $student->LastName }}, {{ $student->FirstName }} {{ $student->MiddleName }}
                    </h1>
                    <p style="margin-left: 2ch">- Home page: displays the students' SO Progress</p>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                    </ol>
                </div>
            </div><!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    Legend:
                    <span class="label label-default">No Rating (0)</span>
                    <span class="label label-danger">Developing (0.01 - 1)</span>
                    <span class="label label-warning">Satisfactory (1.01 - 2)</span>
                    <span class="label label-info">Above Average (2.01 - 3)</span>
                    <span class="label label-success">Excellent (3.01 - 4)</span>
                    <hr/>
                </div>
            </div>

            <div class="row">
                @foreach($outcomes->chunk(4) as $outcomeChunk)
                    <div class="col-lg-12 bottom-pad">
                        @foreach($outcomeChunk as $outcome)
                            <div class="col-lg-3">
                                @if($outcome->pivot->Evaluation <= 0)
                                    <div class="panel panel-default">
                                        @elseif($outcome->pivot->Evaluation <= 1)
                                            <div class="panel panel-danger">
                                                @elseif($outcome->pivot->Evaluation <=2)
                                                    <div class="panel panel-warning">
                                                        @elseif($outcome->pivot->Evaluation <= 3)
                                                            <div class="panel panel-info">
                                                                @else
                                                                    <div class="panel panel-success">
                                                                        @endif

                                                                        <div class="panel-heading">
                                                                            <div class="row">
                                                                                <div class="col-xs-3">
                                                                                    <div class="huge">{{ $outcome->Outcome_Code }}</div>
                                                                                </div>
                                                                                <div class="col-xs-9 text-right">
                                                                                    <div>Overall: <span class="badge">{{ $outcome->pivot->Evaluation }}</span></div>
                                                                                    <div>Events: <span class="badge">{{ $outcome->pivot->EventEval }}</span></div>
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
                                                                                    <div class="col-md-6">
                                                                                        <span class="fa fa-fw fa-compass" aria-hidden="true"></span> {{ $outcome->Outcome_Code }}
                                                                                    </div>
                                                                                    <div class="col-md-6 text-right">
                                                                                        Overall Rating: {{ $outcome->pivot->Evaluation }}
                                                                                    </div>
                                                                                </h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-body" style="min-height: 40vh;">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <!--<editor-fold desc="P1, P2, P3, Event tabs">-->
                                                                                    <ul class="nav nav-tabs">
                                                                                        <li class="active">
                                                                                            <a href="#EventEval{{ $outcome->Outcome_Id }}" data-toggle="tab" aria-expanded="false">
                                                                                                Event <span class="badge">{{ $outcome->pivot->EventEval }}</span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="#P1{{ $outcome->Outcome_Id }}" data-toggle="tab" aria-expanded="false">
                                                                                                P1 <span class="badge">{{ $outcome->pivot->P1 }}</span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="#P2{{ $outcome->Outcome_Id }}" data-toggle="tab" aria-expanded="false">
                                                                                                P2 <span class="badge">{{ $outcome->pivot->P2 }}</span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="#P3{{ $outcome->Outcome_Id }}" data-toggle="tab" aria-expanded="false">
                                                                                                P3 <span class="badge">{{ $outcome->pivot->P3 }}</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <div id="myTabContent" class="tab-content">
                                                                                        @foreach($outcome->performanceIndicators as $pi)
                                                                                            <div class="tab-pane fade" id="{{ $pi->Code . $outcome->Outcome_Id }}">
                                                                                                <div class="well well-sm">Description: {{ $pi->Description }}</div>
                                                                                                <legend>Breakdown of Performance Indicator</legend>
                                                                                                @foreach($pi->requirements()->with(array(
                                                                                                    'students' => function($query) use ($student) {
                                                                                                        $query->where('students.Student_Id', '=', $student->Student_Id);
                                                                                                    },
                                                                                                ))->get() as $requirement)
                                                                                                    <div class="panel panel-default">
                                                                                                        <div class="panel-heading">
                                                                                                            <?php $course = $requirement->baseClass()->get()->first()->course; ?>
                                                                                                            {{ $course->Code }}: {{ $course->Title }}
                                                                                                        </div>
                                                                                                        <div class="panel-body">
                                                                                                            @if($requirement->students->count())
                                                                                                                {{ $requirement->Name }}: {{ $requirement->students->first()->pivot->Score }} / {{ $requirement->HPS }}
                                                                                                            @else
                                                                                                                Not Graded Yet.
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endforeach
                                                                                        <div class="tab-pane fade active in" id="EventEval{{ $outcome->Outcome_Id }}">
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
                                                                                                    <tr>
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
                    </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.eventsTable').DataTable();
        } );
    </script>
@endsection

@section('organizations')
    @foreach($organizations as $org)
        <li>
            <a href="/organizations/{{$org->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$org->Organization_Name}}</a>
        </li>
    @endforeach
@endsection