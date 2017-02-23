@extends('layouts.master')
@section('body')

<script>
    $(document).ready(function(){
        $('#navAdmin').addClass("active");
    });

    $(document).ready(function(){
        $('#pillSections').addClass("active");
    });
</script>

@include('adminpages.navlinks')

{{--Section List--}}
<div class="flexbox">
    <div class="col-lg-3 border-right">
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search Section" />
                <span class="input-group-btn">
            <button class="btn btn-default" type="button">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
            </span>
            </div>
        </div>
        <ul class="nav nav-pills nav-stacked">
            @foreach($sections as $section)
                <li><a href="#">{{ $section->Code }}  SY: {{$section->AcademicYearStart}}-{{$section->AcademicYearEnd}}</a></li>
            @endforeach
            <li>
                <a href="#" class="addSection" data-toggle="modal" data-target="#addSection">
                    <span class="glyphicon glyphicon-plus">&nbsp;</span>Add Section
                </a>
            </li>
        </ul>
    </div>

    <div id="CourseDetails" class="col-lg-9"></div>
</div>
{{--Section List--}}

{{--Modal--}}
<div class="modal" id="addSection" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add Section</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('action' => 'AdminController@addSection', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="Code" class="col-lg-4 control-label" >Section Code</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="Code" name="Code" placeholder="" type="text" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="AcademicYearStart" class="col-lg-4 control-label" >Academic Year Start</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="AcademicYearStart" name="AcademicYearStart" max="2030" value="2016" type="number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="AcademicYearEnd" class="col-lg-4 control-label" >Academic Year End</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="AcademicYearEnd" name="AcademicYearEnd" type="number" max="2030" value="2017" required/>
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