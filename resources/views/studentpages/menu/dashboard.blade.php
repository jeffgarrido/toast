@extends('studentpages.layout.studentLayout')

@section('body')

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-fw fa-dashboard"></i>Student Dashboard <small>Statistics Overview</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div><!-- row -->

        <div class="row">
            @foreach($student->studentOutcomes->chunk(4) as $outcomeChunk)
                <div class="col-lg-12 bottom-pad">
                    @foreach($outcomeChunk as $outcome)
                        {{--<div class="col-lg-3">--}}
                            {{--@if($outcome->pivot->Evaluation <= 1)--}}
                            {{--<button type="button" class="btn btn-lg btn-default btn-block" data-toggle="collapse" data-target="#SOContent{{ $outcome->Outcome_Id }}">--}}
                            {{--@elseif($outcome->pivot->Evaluation <= 2)--}}
                            {{--<button type="button" class="btn btn-lg btn-danger btn-block" data-toggle="collapse" data-target="#SOContent{{ $outcome->Outcome_Id }}">--}}
                            {{--@elseif($outcome->pivot->Evaluation <= 3)--}}
                            {{--<button type="button" class="btn btn-lg btn-warning btn-block" data-toggle="collapse" data-target="#SOContent{{ $outcome->Outcome_Id }}">--}}
                            {{--@else--}}
                            {{--<button type="button" class="btn btn-lg btn-success btn-block" data-toggle="collapse" data-target="#SOContent{{ $outcome->Outcome_Id }}">--}}
                            {{--@endif--}}
                                {{--{{ $outcome->Outcome_Code }} <span class="badge">{{ $outcome->pivot->Evaluation }}</span>--}}
                            {{--</button>--}}
                            {{--<div id="SOContent{{ $outcome->Outcome_Id }}" class="collapse">--}}
                                {{--{{ $outcome->Description }}--}}
                            {{--</div>--}}
                        {{--</div>--}}
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

@section('organizations')
    @foreach($organizations as $org)
        <li>
            <a href="/organizations/{{$org->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$org->Organization_Name}}</a>
        </li>
    @endforeach
@endsection