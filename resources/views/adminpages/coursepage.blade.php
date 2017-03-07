@extends('layouts.master')
@section('body')

    <script>
        $(document).ready(function(){
            $('#navAdmin').addClass("active");
        });

        $(document).ready(function(){
            $('#pillCourses').addClass("active");
        });
    </script>

    @include('adminpages.navlinks')

    {{--Course List--}}
    <div class="flexbox">
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
                    <li class="getCourseDetails" data="{{ $course->Course_Id }}"><a href="#">{{$course->Code}}: {{ $course->Title }}</a></li>
                @endforeach
                <script>
                    $('.getCourseDetails').click(function(){
                        $('.loading-div').show();
                        getCourseDetails(this.getAttribute('data'));
                    })
                </script>
                <li>
                    <a href="#" class="addCourse" data-toggle="modal" data-target="#addCourse">
                        <span class="glyphicon glyphicon-plus">&nbsp;</span>Add Courses
                    </a>
                </li>
            </ul>
        </div>

        <div id="CourseDetails" class="col-lg-9"></div>
    </div>
    {{--Course List--}}

    {{--MODAL--}}
    <div class="modal" id="addCourse" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add Course</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('action' => 'AdminController@addCourse', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="Code" class="col-lg-4 control-label" >Course Code</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Code" name="Code" placeholder="" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Title" class="col-lg-4 control-label" >Course Equivalent</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Title" name="Title" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Units" class="col-lg-4 control-label" >No. of Units</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Units" name="Units" type="number" max="6" value="2" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Description" class="col-lg-4 control-label" >Course Description</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Description" name="Description" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Terms" class="col-lg-4 control-label" >No. of Terms</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Units" name="Terms" type="Terms" max="4" value="2" required/>
                            </div>
                        </div>
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

@endsection