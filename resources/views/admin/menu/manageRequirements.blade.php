@extends('admin.layout.adminLayout')

@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> {{ $course->Code }}: {{ $course->Title }} <small>Requirements</small>
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
                    <li>
                        <i class="fa fa-male"></i> <a href="/classes/{{$baseClass->BaseClass_Id}}">{{ $professor->LastName }}, {{ substr($professor->FirstName, 0,1) }}.</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-graduation-cap"></i> Requirements
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12">
                @for($i = 0; $i < $course->Terms; $i++)
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <Legend style="border-bottom: 1px #eeeeee solid;">{{ $terms[$i] }}</Legend>
                            @if(count($baseClass->requirements()->where('Term', '=', $i+1)->get()) > 0)
                                <table class="table table-hover table-condensed table-responsive table-bordered">
                                    <thead>
                                    <th class="th-fit">Name</th>
                                    <th class="th-fit">Highest Possible Score</th>
                                    <th class="th-fit">Weight</th>
                                    <th>Description</th>
                                    <th class="th-fit">Actions</th>
                                    </thead>
                                    <tbody>
                                    @foreach($baseClass->requirements()->where('Term', '=', $i+1)->get() as $requirement)
                                        <tr data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">
                                            <td class="td-fit" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Name}}</td>
                                            <td class="td-fit" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->HPS}}</td>
                                            <td class="td-fit" data-target="#editRequirement{{ $requirement->Requirement_Id }}">{{$requirement->Weight}}</td>
                                            <td>{{$requirement->Description}}</td>
                                            <td class="td-fit"><button type="button" class="btn btn-danger btn-xs button-delete"><i class="fa fa-remove"></i> Delete</button></td>
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
                    @foreach($baseClass->requirements()->where('Term', '=', $i+1)->get() as $requirement)
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
                                                    <input class="form-control" id="Weight" name="Weight" placeholder="%" type="number" min="0" value="{{ $requirement->Weight }}" required/>
                                                    <span class="help-block">
                                                Note: Percentages are applied on a per term basis.<br>
                                                Semestral grade is computed as 50% prelim grade + 50% final grade.
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
                                                                    <option value="{{$pIndicator->PI_Id}}" {{$requirement->outcomes()->get()->contains($pIndicator)? 'selected="selected"' : ''}}>
                                                                        {{ $pIndicator->Code }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <script>
                                                $('.outcomeList').multiselect();
                                            </script>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <hr/>
                                                    <div class="col-lg-10 col-lg-offset-2 text-right">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                        <button type="reset" class="btn btn-info">Clear Form</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                                    {{ Form::open(array('url' => '/requirements/' . $baseClass->BaseClass_Id, 'method' => 'POST', 'class' => 'form-horizontal')) }}
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
                                                <input class="form-control" id="Weight" name="Weight" placeholder="%" type="number" min="0" required/>
                                                <span class="help-block">
                                                Note: Percentages are applied on a per term basis.<br>
                                                Semestral grade is computed as 50% prelim grade + 50% final grade.
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
                                                                <option value="{{$pIndicator->PI_Id}}">{{ $pIndicator->Code }}</option>
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
                                                    <button type="reset" class="btn btn-info">Clear Form</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
    $('.outcomeList').multiselect();
</script>

@endsection