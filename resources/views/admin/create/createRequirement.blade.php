@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-plus"></b> Add Requirement
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> <a href="/classes"> Classes</a>
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> <a href="/classes/{{ $class->Class_Id }}">{{ $class->course->Code }}</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> Add Requirement
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            <div class="alert alert-dismissible alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Heads up!</strong> Adding a requirement to this course also adds the same requirement to all courses with the same course code and professor.
            </div>

            {{ Form::open(array('action' => array('RequirementController@store', $class->Class_Id), 'method' => 'POST', 'class' => 'form-horizontal')) }}
            <fieldset>
                @for($i = 0; $i < $class->course->Terms; $i++)
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <Legend style="border-bottom: 1px #eeeeee solid;">{{ $terms[$i] }}</Legend>
                            @if(count($class->course->requirements()->where('Term', '=', $i+1)->get()) > 0)
                                <table class="table table-hover">
                                    <thead>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @foreach($class->course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
                                        <tr data-toggle="modal" data-target="#editRequirement{{ $requirement->Requirement_Id }}">
                                            <td>{{$requirement->Type}}</td>
                                            <td>{{$requirement->Description}}</td>
                                            <td class="text-right"><button type="button" class="btn btn-danger btn-xs" onclick="">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button></td>
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
                    @foreach($class->course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
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
                                        {{ Form::open(array('action' => array('CourseController@editRequirement', $requirement->Requirement_Id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                                        <fieldset>
                                            <input type="hidden" name="id" value="{{ $class->course->Course_Id }}"/>
                                            <div class="form-group">
                                                <label for="Type" class="col-lg-2 control-label">Type of Requirement</label>
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="Type" name="Type" placeholder="Type" type="text" required value="{{ $requirement->Type }}"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Description" class="col-lg-2 control-label">Description</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" rows="3" id="Description" name="Description">{{ $requirement->Description }}</textarea>
                                                    <span class="help-block">Note: Description is optional</span>
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="form-group">
                                                <div class="col-lg-10 col-lg-offset-2 text-right">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                    <button type="reset" class="btn btn-info">Clear Form</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
                                    <h3 class="modal-title" id="myModalLabel">Add Requirement</h3>
                                </div>
                                <div class="modal-body">
                                    {{ Form::open(array('action' => array('CourseController@addRequirement', $class->course->Course_Id), 'method' => 'POST', 'class' => 'form-horizontal')) }}
                                    <fieldset>
                                        <input type="hidden" name="Term" value="{{ $i+1 }}"/>
                                        <div class="form-group">
                                            <label for="Type" class="col-lg-2 control-label">Type of Requirement</label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="Type" name="Type" placeholder="Type" type="text" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Description" class="col-lg-2 control-label">Description</label>
                                            <div class="col-lg-10">
                                                <textarea class="form-control" rows="3" id="Description" name="Description"></textarea>
                                                <span class="help-block">Note: Description is optional</span>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="form-group">
                                            <div class="col-lg-10 col-lg-offset-2 text-right">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                <button type="reset" class="btn btn-info">Clear Form</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
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
                <div class="col-lg-5">
                    <legend>Requirement Details</legend>
                    <div class="form-group">
                        <label for="Code" class="col-lg-4 control-label" >Requirement Type</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="Type" name="Type" placeholder="Requirement Type" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Description" class="col-lg-4 control-label" >Description</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="Description" name="Description" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Description" class="col-lg-4 control-label" >Term</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="Description" name="Description" required/>
                        </div>
                    </div>
                </div>
            </fieldset>
            {{ Form::close() }}

        </div>
    </div>

@endsection