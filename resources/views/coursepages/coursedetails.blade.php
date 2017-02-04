{{--Header--}}
<div class="flexbox justified-flexbox">
    <div class="col-lg-8">
        <h4>{{ $course->Code }}: {{ $course->Title }}</h4>
        @if($course->Description)
            <h7>{{ $course->Description }}</h7>
        @endif
    </div>
    <div class="col-lg-4 align-right">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editCourseModal">Edit&nbsp;<span class="glyphicon glyphicon-pencil"></span></button>
        <button type="button" class="btn btn-danger" onclick="deleteCourse({{ $course->id }})">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
    </div>
</div>
{{--/Header--}}

<hr/>

{{--Body--}}
<h6>Requirements:</h6>
@for($i = 0; $i < $course->Terms; $i++)
    <div id="requirements">
        <div class="panel panel-primary">
            <div class="panel-body">
                <Legend style="border-bottom: 1px #eeeeee solid;">{{ $terms[$i] }}</Legend>
                @if(count($course->requirements()->where('Term', '=', $i+1)->get()) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th>Type</th>
                            <th>Description</th>
                            <th></th>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @foreach($course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
                                <tr data-toggle="modal" data-target="#editRequirement{{ $requirement->id }}">
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
    </div>

    {{--Edit Requirement Modal--}}
    @foreach($course->requirements()->where('Term', '=', $i+1)->get() as $requirement)
        <div class="modal fade" id="editRequirement{{ $requirement->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" id="myModalLabel">Edit Requirement</h3>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('action' => array('CourseController@editRequirement', $requirement->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <input type="hidden" name="id" value="{{ $course->id }}"/>
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
                    {{ Form::open(array('action' => array('CourseController@addRequirement', $course->id), 'method' => 'POST', 'class' => 'form-horizontal')) }}
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
{{--/Body--}}

{{--Edit Course Modal--}}
<div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">Edit Course</h3>
            </div>
            <div class="modal-body">
                {{ Form::open(array('action' => array('CourseController@editCourse', $course->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="Code" class="col-lg-2 control-label">Course Code</label>
                        <div class="col-lg-10">
                            <input class="form-control" id="Code" name="Code" placeholder="Course Code" type="text" value="{{ $course->Code }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Title" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input class="form-control" id="Title" name="Title" placeholder="Title" type="text" value="{{ $course->Title }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Title" class="col-lg-2 control-label">Units</label>
                        <div class="col-lg-10">
                            <input class="form-control" id="Units" name="Units" placeholder="Units" type="number" value="{{ $course->Units }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Terms" class="col-lg-2 control-label">Number of Terms</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="Terms" name="Terms" required>
                                <option {{ ($course->Terms == 2) ? 'selected="selected"': '' }}>2</option>
                                <option {{ ($course->Terms == 3) ? 'selected="selected"': '' }}>3</option>
                                <option {{ ($course->Terms == 4) ? 'selected="selected"': '' }}>4</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Description" class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="Description" name="Description" style="resize: vertical;">{{ $course->Description }}</textarea>
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
{{--/Edit Course Modal--}}