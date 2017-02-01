@extends('layouts.master')
@section('body')

@if(session()->has('id'))
<script>
    $(document).ready(function(){
        getCourseDetails({{ session('id') }});
    });
</script>
@endif

@include('includes.loader')

<script>
    $(document).ready(function(){
        $('#navCourses').addClass("active");
    });
</script>

{{--Course List--}}
<div class=" flexbox">
    <div class="col-lg-3 border-right">
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search Course" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
                </span>
            </div>
        </div>
        <ul class="nav nav-pills nav-stacked">
            @foreach($courses as $course)
                <li class="getCourseDetails" data="{{ $course->id }}"><a href="#">{{ $course->Code }}: {{ $course->Title }}</a></li>
            @endforeach
            <script>
                $('.getCourseDetails').click(function(){
                    $('.loading-div').show();
                    getCourseDetails(this.getAttribute('data'));
                })
            </script>
            <li>
                <a href="#" class="addCourse" data-toggle="modal" data-target="#addCourse">
                    <span class="glyphicon glyphicon-plus">&nbsp;</span>Add Course
                </a>
            </li>
        </ul>
    </div>

    <div id="CourseDetails" class="col-lg-9"></div>
</div>
{{--/Course List--}}

{{--Add Course Modal--}}
<div class="modal fade" id="addCourse" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">Add Course</h3>
            </div>
            <div class="modal-body">
                {{ Form::open(array('action' => 'CourseController@addCourse', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="Code" class="col-lg-2 control-label">Course Code</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="Code" name="Code" placeholder="Course Code" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Title" class="col-lg-2 control-label">Title</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="Title" name="Title" placeholder="Title" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Title" class="col-lg-2 control-label">Units</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="Units" name="Units" placeholder="Units" type="number" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Terms" class="col-lg-2 control-label">Number of Terms</label>
                            <div class="col-lg-10">
                                <select class="col-lg-10 form-control" id="Terms" name="Terms" required>
                                    <option selected="selected">2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Description" class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" id="Description" name="Description" style="resize: vertical;"></textarea>
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
{{--/Add Course Modal--}}

{{--Ajax Scripts--}}
<script src="js/ajax.js"></script>
{{--customjs Scripts--}}
<script src="js/customjs.js"></script>

@endsection

