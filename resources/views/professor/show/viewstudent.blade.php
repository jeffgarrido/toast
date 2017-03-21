@extends('professor.layout.professorLayout')

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
                        <li class="active">
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-users"></i> <a href="/pstudents">Students</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-child"></i> {{ $student->LastName }}, {{ substr($student->FirstName, 0,1) }}
                        </li>
                    </ol>
                </div>
            </div><!-- row -->

            <div class="row">
                @foreach($student->studentOutcomes->chunk(4) as $outcomeChunk)
                    <div class="col-lg-12 bottom-pad">
                        @foreach($outcomeChunk as $outcome)
                            <div class="col-lg-3">
                                @if($outcome->pivot->Evaluation <= 1)
                                    <div class="panel panel-default">
                                        @elseif($outcome->pivot->Evaluation <= 2)
                                            <div class="panel panel-danger">
                                                @elseif($outcome->pivot->Evaluation <= 3)
                                                    <div class="panel panel-warning">
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
                                                                <a href="/outcome/{{ $outcome->Outcome_Id }}">
                                                                    <div class="panel-footer">
                                                                        <span class="pull-left">View Details</span>
                                                                        <span class="pull-right"><i class="fa fa-arrow-circle-o-right"></i></span>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                    </div>
                                                    @endforeach
                                            </div>
                                            @endforeach
                                    </div>

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

@endsection