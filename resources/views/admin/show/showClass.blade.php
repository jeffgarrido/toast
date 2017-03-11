@extends('admin.layout.adminLayout')

@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> {{ $class->course->Code }}: {{ $class->course->Title }}
                    <div class="pull-right">
                        {{ Form::open(array('url' => '/classes/' . $class->Class_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                        <a href="/classes/{{ $class->Class_Id }}/edit" class="btn btn-lg btn-warning" aria-hidden="true">
                            <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                        </a>
                        <button type="submit" class="btn btn-lg btn-danger button-delete" aria-hidden="true">
                            <span class="fa fa-remove"></span> Delete
                        </button>
                        {{ Form::close() }}
                    </div>
                </h1>
                <div class="well well-sm">
                    <p>Professor: {{ $professor->LastName }}, {{ $professor->FirstName }} {{ $professor->MiddleName }}</p>
                    <p>Section: {{ ($class->section != null)? $class->section->Code . ' A.Y. ' . $class->section->AcademicYearStart . ' - ' . $class->section->AcademicYearEnd: '' }}</p>
                </div>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> <a href="/classes"> Classes</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-edit"></i> {{ $class->course->Code }}
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12 text-right bottom-pad">
                <a href="/requirements/{{$class->Class_Id}}/create" class="btn btn-success"><i class="fa fa-plus"></i> Add Requirement</a>
                <a href="/requirements/{{$class->Class_Id}}/list" class="btn btn-success"><i class="fa fa-search"></i> View Requirement</a>
            </div>
            <div class="col-lg-12">
                <table id="ClassTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">

                    <!--<editor-fold desc="Class Table Head">-->
                    <thead>
                    <tr>
                        <th class="th-fit">Student Number</th>
                        <th>Name</th>
                        @foreach($class->requirements() as $requirement)
                            <th>$requirement->Type</th>
                        @endforeach
                    </tr>
                    </thead>
                    <!--</editor-fold>-->

                    <tbody>
                    @foreach($students as $student)
                        <tr class="record-details" data-href="/students/{{ $student->Student_Id }}">
                            <td class="td-fit">{{$student->StudentNumber}}</td>
                            <td>{{$student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName}}</td>
                            @foreach($class->requirements() as $requirement)
                                <td></td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>

                </table>

                <!--<editor-fold desc="Class Data Table Script">-->
                <script>
                    $(document).ready(function() {
                        $('#ClassTable').DataTable({
                            paging: false,
                            order: [1, 'asc'],
                        });
                    } );
                </script>
                <!--</editor-fold>-->

            </div>
        </div>

    </div>
</div>

@endsection