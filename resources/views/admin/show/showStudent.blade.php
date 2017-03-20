@extends('admin.layout.adminLayout')

@section('body')

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-fw fa-child"></i>{{ $student->LastName }}, {{ $student->FirstName }} {{ $student->MiddleName }}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-users"></i> Manage Users
                    </li>
                    <li>
                        <i class="fa fa-child"></i> <a href="/students">Students</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-child"></i> {{ $student->LastName }}, {{ substr($student->FirstName, 0,1) }}
                    </li>
                </ol>
            </div>
        </div><!-- row -->

        <div class="row">
            <div class="col-lg-12">
                Legend:
                <span class="label label-default">No Rating</span>
                <span class="label label-danger">Developing</span>
                <span class="label label-warning">Satisfactory</span>
                <span class="label label-info">Above Average</span>
                <span class="label label-success">Excellent</span>
                <hr/>
            </div>
        </div>

        <div class="row">
            @foreach($student->studentOutcomes->chunk(4) as $outcomeChunk)
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
                                    <div class="modal-body">
                                        <div class="row">
                                            <!--<editor-fold desc="Panel for P1">-->
                                            <div class="col-lg-3">
                                                @if($outcome->pivot->P1 <= 0)
                                                <div class="panel panel-default">
                                                @elseif($outcome->pivot->P1 <= 1)
                                                <div class="panel panel-danger">
                                                @elseif($outcome->pivot->P1 <=2)
                                                <div class="panel panel-warning">
                                                @elseif($outcome->pivot->P1 <= 3)
                                                <div class="panel panel-info">
                                                @else
                                                <div class="panel panel-success">
                                                @endif
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                P1
                                                            </div>
                                                            <div class="col-xs-9 text-right">
                                                                Overall: {{ $outcome->pivot->P1 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--</editor-fold>-->
                                            <!--<editor-fold desc="Panel for P2">-->
                                            <div class="col-lg-3">
                                                @if($outcome->pivot->P2 <= 0)
                                                <div class="panel panel-default">
                                                @elseif($outcome->pivot->P2 <= 1)
                                                <div class="panel panel-danger">
                                                @elseif($outcome->pivot->P2 <=2)
                                                <div class="panel panel-warning">
                                                @elseif($outcome->pivot->P2 <= 3)
                                                <div class="panel panel-info">
                                                @else
                                                <div class="panel panel-success">
                                                @endif
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                P2
                                                            </div>
                                                            <div class="col-xs-9 text-right">
                                                                Overall: {{ $outcome->pivot->P2 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--</editor-fold>-->
                                            <!--<editor-fold desc="Panel for P3">-->
                                            <div class="col-lg-3">
                                                @if($outcome->pivot->P3 <= 0)
                                                <div class="panel panel-default">
                                                @elseif($outcome->pivot->P3 <= 1)
                                                <div class="panel panel-danger">
                                                @elseif($outcome->pivot->P3 <=2)
                                                <div class="panel panel-warning">
                                                @elseif($outcome->pivot->P3 <= 3)
                                                <div class="panel panel-info">
                                                @else
                                                <div class="panel panel-success">
                                                @endif
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                P3
                                                            </div>
                                                            <div class="col-xs-9 text-right">
                                                                Overall: {{ $outcome->pivot->P3 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--</editor-fold>-->
                                            <!--<editor-fold desc="Panel for Event Evaluation">-->
                                            <div class="col-lg-3">
                                                @if($outcome->pivot->EventEval <= 0)
                                                <div class="panel panel-default">
                                                @elseif($outcome->pivot->EventEval <= 1)
                                                <div class="panel panel-danger">
                                                @elseif($outcome->pivot->EventEval <=2)
                                                <div class="panel panel-warning">
                                                @elseif($outcome->pivot->EventEval <= 3)
                                                <div class="panel panel-info">
                                                @else
                                                <div class="panel panel-success">
                                                @endif
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                Events
                                                            </div>
                                                            <div class="col-xs-9 text-right">
                                                                Overall: {{ $outcome->pivot->EventEval }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--</editor-fold>-->
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

@endsection