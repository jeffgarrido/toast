@extends('admin.layout.adminLayout')

@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> {{ $course->Code }}: {{ $course->Title }}
                    <a href="/courses/{{ $course->Course_Id }}/edit" class="btn btn-lg btn-warning pull-right" aria-hidden="true">
                        <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                    </a>
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
                                <tr>
                                    <td class="td-fit">{{ $outcome->Outcome_Code }}</td>
                                    <td>{{ $outcome->Description }}</td>
                                </tr>
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
                                    <th class="th-fit">Actions</th>
                                    </thead>
                                    <tbody>
                                    @foreach($course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
                                        <tr>
                                            <td class="td-fit" data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Name}}</td>
                                            <td class="td-fit" data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->HPS}}</td>
                                            <td class="td-fit" data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Weight}}</td>
                                            <td data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Description}}</td>
                                            <td class="td-fit">
                                                {{ Form::open(array('url' => '/requirements/' . $requirement->Requirement_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                                    <button type="submit" class="btn btn-danger btn-xs button-delete"><i class="fa fa-remove"></i> Delete</button>
                                                {{ Form::close() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <h6><span class="help-block">Note: Click on a record to edit.</span></h6>
                            @else
                                <span class="help-block">No requirements yet.</span>
                            @endif
                            <button type="button" class="btn btn-default btn-block btn-sm" data-toggle="modal" data-target="#addRequirement{{ $i }}">
                                <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Requirement
                            </button>
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
                                        {{ Form::open(array('url' => '/requirements/' . $requirement->Requirement_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                                        <fieldset>
                                            <input type="hidden" name="Term" value="{{ $i+1 }}"/>
                                            <div class="form-group">
                                                <label for="Name" class="col-lg-4 control-label">Requirement Name</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" id="Name" name="Name" type="text" value="{{ $requirement->Name }}" required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="HPS" class="col-lg-4 control-label">Highest Possible Score</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" id="HPS" name="HPS" placeholder="0" type="number" min="0" value="{{ $requirement->HPS }}" required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Weight" class="col-lg-4 control-label">Grade Weight</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" id="Weight" name="Weight" placeholder="%" type="number" step="0.01" min="0" value="{{ $requirement->Weight }}" required/>
                                                    <span class="help-block">
                                                        Note: Weight applies to per term basis.<br/>
                                                        To compute for the final grade, a default of computation of 50% PG + 50% FG is used.
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Description" class="col-lg-4 control-label">Description</label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control" rows="3" id="Description" name="Description">{{ $requirement->Description }}</textarea>
                                                    <span class="help-block">Note: Description is optional</span>
                                                </div>
                                            </div>

                                            @foreach($course->outcomes()->get() as $outcome)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Code" class="col-lg-4 control-label" >{{$outcome->Outcome_Code}}</label>
                                                        <div class="col-lg-7">
                                                            <select class="form-control outcomeList" multiple="multiple" id="course" name="outcomes[]">
                                                                @foreach($outcome->performanceIndicators()->get() as $pIndicator)
                                                                    <option title="{{ $pIndicator->Description }}" value="{{$pIndicator->PI_Id}}" {{$requirement->outcomes()->get()->contains($pIndicator)? 'selected="selected"' : ''}}>
                                                                        {{ $pIndicator->Code }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <hr/>
                                                    <div class="col-lg-10 col-lg-offset-2 text-right">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"><span class="fa fa-floppy-o"></span> Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{--/Edit Requirement Modal--}}

                    {{--Add Requirement Modal--}}
                    <div class="modal fade" id="addRequirement{{ $i }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h3 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Add Requirement</h3>
                                </div>
                                <div class="modal-body">
                                    {{ Form::open(array('url' => '/requirements/' . $course->Course_Id, 'method' => 'POST', 'class' => 'form-horizontal')) }}
                                    <fieldset>
                                        <input type="hidden" name="Term" value="{{ $i+1 }}"/>
                                        <div class="form-group">
                                            <label for="Name" class="col-lg-4 control-label">Requirement Name</label>
                                            <div class="col-lg-7">
                                                <input class="form-control" id="Name" name="Name" type="text" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="HPS" class="col-lg-4 control-label">Highest Possible Score</label>
                                            <div class="col-lg-7">
                                                <input class="form-control" id="HPS" name="HPS" placeholder="0" type="number" min="0" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Weight" class="col-lg-4 control-label">Grade Weight</label>
                                            <div class="col-lg-7">
                                                <input class="form-control" id="Weight" name="Weight" placeholder="%" type="number" step="0.01" min="0" required/>
                                                <span class="help-block">
                                                    Note: Weight applies to per term basis.<br/>
                                                    To compute for the final grade, a default of computation of 50% PG + 50% FG is used.
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Description" class="col-lg-4 control-label">Description</label>
                                            <div class="col-lg-7">
                                                <textarea class="form-control" rows="3" id="Description" name="Description"></textarea>
                                                <span class="help-block">Note: Description is optional</span>
                                            </div>
                                        </div>

                                        @foreach($course->outcomes()->get() as $outcome)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Code" class="col-lg-4 control-label" >{{$outcome->Outcome_Code}}</label>
                                                    <div class="col-lg-7">
                                                        <select class="form-control outcomeList" multiple="multiple" id="course" name="outcomes[]">
                                                                @foreach($outcome->performanceIndicators()->get() as $pIndicator)
                                                                    <option value="{{$pIndicator->PI_Id}}" title="{{ $pIndicator->Description }}">
                                                                        {{ $pIndicator->Code }}
                                                                    </option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <hr/>
                                                <div class="col-lg-10 col-lg-offset-2 text-right">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><span class="fa fa-floppy-o"></span> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--/Add Requirement Modal--}}
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