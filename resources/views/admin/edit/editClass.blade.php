@extends('admin.layout.adminLayout')
@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> Edit Class
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> <a href="/classes">Classes</a>
                    </li>
                    <li>
                        <i class="fa fa-book"></i>  <a href="/courses/{{ $course->Course_Id }}">{{ $course->Code }}</a>
                    </li>
                    <li>
                        <i class="fa fa-male"></i> <a href="/classes/{{ $class->baseClass->BaseClass_Id }}">{{ $professor->LastName }}, {{ substr($professor->FirstName, 0,1) }}.</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-edit"></i> <a href="/class/{{ $class->Class_Id }}">{{ $section->Code }}</a>
                    </li>
                    <li>
                        <i class="fa fa-pencil"></i> Edit Class
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        {{ Form::open(array('url' => '/class/' .  $class->Class_Id , 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
        <fieldset>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="Code" class="col-lg-4 control-label" >Change Course</label>
                    <div class="col-lg-7">
                        <select class="form-control" id="course" name="course" disabled required>
                                <option value="{{$course->Course_Id}}">
                                    {{ $course->Code }}: {{ $course->Title }}
                                </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="AcademicYearStart" class="col-lg-4 control-label" >Change Professor</label>
                    <div class="col-lg-7">
                        <select class="form-control" id="professor" name="professor" disabled required>
                                <option value="{{$professor->Professor_Id}}">
                                    {{ $professor->LastName}}, {{ $professor->FirstName}} {{ $professor->MiddleName }}
                                </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="AcademicYearStart" class="col-lg-4 control-label" >Change Section</label>
                    <div class="col-lg-7">
                        <select class="form-control" id="section" name="section" disabled required>
                            <option value="{{$section->Section_Id}}">
                                {{ $section->Code}} A.Y {{ $section->AcademicYearStart }} - {{ $section->AcademicYearEnd }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="form-group">
                    <select id="studentList" multiple="multiple" name="studentList[]">
                        @foreach($students as $student)
                            <option value="{{ $student->Student_Id }}" {{ $class->students->contains($student)? 'selected="selected"' : '' }}>
                                {{ $student->StudentNumber }}: {{ $student->LastName. ", " . $student->FirstName . " " . $student->MiddleName}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#studentList').bootstrapDualListbox({
                        nonSelectedListLabel: 'All Students',
                        selectedListLabel: 'Selected Student/s',
                        preserveSelectionOnMove: false,
                        moveOnSelect: true,
                        selectorMinimalHeight: 200,
                    });
                });
            </script>

            <div class="col-lg-12">
                <hr/>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2 text-right">
                        <button type="reset" class="btn btn-info">Clear Form</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </fieldset>
        {{ Form::close() }}

    </div>
</div>
@endsection