@extends('layouts.master')
@section('body')

<script>
    $(document).ready(function(){
        $('#navOrganization').addClass("active");
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
                @foreach($organization as $org)
                    <li><a href="#">{{ $org->Organization_Name }}</a></li>
                @endforeach
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


@endsection