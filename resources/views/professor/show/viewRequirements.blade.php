@extends('professor.layout.professorLayout')

@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> {{ $course->Code }}: {{ $course->Title }}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> <a href="/classes"> Classes</a>
                    </li>
                    <li>
                        <i class="fa fa-book"></i> <a href="/courses/{{ $course->Course_Id }}">{{ $course->Code }}</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-graduation-cap"></i> Requirements
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <!--<editor-fold desc="Student Outcomes">-->
        <legend>Applicable Student Outcomes</legend>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-condensed table-responsive table-bordered">
                    <thead>
                    <th class="th-fit">Outcome Code</th>
                    <th>Description</th>
                    </thead>
                    <tbody>
                        @if($outcomes->count() > 0)
                            @foreach($outcomes as $outcome)
                                <tr data-toggle="modal" data-target="#outcome_modal{{$outcome->Outcome_Id}}">
                                    <td class="td-fit">{{ $outcome->Outcome_Code }}</td>
                                    <td>{{ $outcome->Description }}</td>
                                </tr>

                                <div class="modal fade" id="outcome_modal{{$outcome->Outcome_Id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h2 class="modal-title">{{ $outcome->Outcome_Code }}</h2>
                                                <small>Description: {{ $outcome->Description }}</small>
                                            </div>
                                            <div class="modal-body">
                                                <legend>Performance Indicators</legend>
                                                @foreach($outcome->performanceIndicators as $pi)
                                                    <p>{{ $pi->Code }}: {{ $pi->Description }}<br /></p>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">
                                    No outcomes tagged to this course yet.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12">
                @for($i = 0; $i < $course->Terms; $i++)
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <Legend style="border-bottom: 1px #eeeeee solid;">{{ $terms[$i] }}</Legend>
                            @if(count($course->requirements()->where('Term', '=', $i+1)->get()) > 0)
                                <table class="table table-hover table-condensed table-responsive table-bordered">
                                    <thead>
                                    <th class="th-fit">Name</th>
                                    <th class="th-fit">Highest Possible Score</th>
                                    <th class="th-fit">Weight</th>
                                    <th>Description</th>
                                    </thead>
                                    <tbody>
                                    @foreach($course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
                                        <tr>
                                            <td class="td-fit" data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Name}}</td>
                                            <td class="td-fit" data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->HPS}}</td>
                                            <td class="td-fit" data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Weight}}</td>
                                            <td data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Description}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <h6><span class="help-block">Note: Click on a record to view details.</span></h6>
                            @else
                                <span class="help-block">No requirements yet.</span>
                            @endif
                        </div>
                    </div>

                    {{--Edit Requirement Modal--}}
                    @foreach($course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
                        <div class="modal fade" id="editRequirement{{ $requirement->Requirement_Id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h3 class="modal-title" id="myModalLabel">Edit Requirement</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal">
                                            <fieldset disabled>
                                                <input type="hidden" name="Term" value="{{ $i+1 }}"/>
                                                <div class="form-group">
                                                    <label for="Name" class="col-lg-4 control-label">Requirement Name</label>
                                                    <div class="col-lg-7">
                                                        <input class="form-control" id="Name" name="Name" type="text" value="{{ $requirement->Name }}" required disabled/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="HPS" class="col-lg-4 control-label">Highest Possible Score</label>
                                                    <div class="col-lg-7">
                                                        <input class="form-control" id="HPS" name="HPS" placeholder="0" type="number" min="0" value="{{ $requirement->HPS }}" required disabled/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Weight" class="col-lg-4 control-label">Grade Weight</label>
                                                    <div class="col-lg-7">
                                                        <input class="form-control" id="Weight" name="Weight" placeholder="%" type="number" step="0.01" min="0" value="{{ $requirement->Weight }}" required disabled/>
                                                        <span class="help-block">
                                                            Note: Weight applies to per term basis.<br/>
                                                            To compute for the final grade, a default of computation of 50% PG + 50% FG is used.
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Description" class="col-lg-4 control-label">Description</label>
                                                    <div class="col-lg-7">
                                                        <textarea class="form-control" rows="3" id="Description" name="Description" disabled>{{ $requirement->Description }}</textarea>
                                                        <span class="help-block">Note: Description is optional</span>
                                                    </div>
                                                </div>

                                                @foreach($course->outcomes()->get() as $outcome)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Code" class="col-lg-4 control-label" >{{$outcome->Outcome_Code}}</label>
                                                            <div class="col-lg-7">
                                                                <select class="form-control outcomeList" multiple="multiple" id="course" name="outcomes[]" disabled>
                                                                    @foreach($outcome->performanceIndicators()->get() as $pIndicator)
                                                                        <option value="{{$pIndicator->PI_Id}}" {{$requirement->outcomes()->get()->contains($pIndicator)? 'selected="selected"' : ''}}>
                                                                            {{ $pIndicator->Code }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-lg-10 col-lg-offset-2 text-right">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{--/Edit Requirement Modal--}}
                @endfor
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('.outcomeList').multiselect({
            includeSelectAllOption: true,
        });
    });
</script>

@endsection