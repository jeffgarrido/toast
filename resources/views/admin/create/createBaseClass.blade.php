@extends('admin.layout.adminLayout')
@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> Add Class
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> <a href="/classes"> Classes</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-edit"></i> Add Class
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        {{ Form::open(array('url' => '/classes', 'method' => 'POST', 'class' => 'form-horizontal')) }}
            <div class="col-lg-5">
                <!--<editor-fold desc="Courses list">-->
                <div class="form-group">
                    <label for="CoursesList" class="control-label col-lg-4">Select Course</label>
                    <div class="col-lg-7">
                        <select class="form-control" id="CoursesList" name="CoursesList" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->Course_Id}}">
                                {{ $course->Code }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <!--</editor-fold>-->

                <!--<editor-fold desc="Professors list">-->
                <div class="form-group">
                    <label for="ProfessorsList" class="col-lg-4 control-label">Select Professor</label>
                    <div class="col-lg-7">
                        <select class="form-control" id="ProfessorsList" name="ProfessorsList" required>
                        @foreach($professors as $professor)
                            <option value="{{ $professor->Professor_Id }}">
                                {{ $professor->LastName. ", " . $professor->FirstName . " " . $professor->MiddleName}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!--</editor-fold>-->


            </div>
        {{ Form::close() }}

    </div>
</div>

@endsection