@extends('admin.layout.adminLayout')
@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> Classes
                    <!--<editor-fold desc="Add Class Button">-->
                    <a href="/classes/create" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add Class
                    </a>
                    <!--</editor-fold>-->
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-edit"></i> Classes
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12">
                <table id="ClassTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">

                    <!--<editor-fold desc="Class Table Head">-->
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Course</th>
                        <th>Professor</th>
                        <th class="th-fit">Actions</th>
                    </tr>
                    </thead>
                    <!--</editor-fold>-->

                    <tbody>
                    <?php $count = 1;?>
                    @foreach($classes as $class)
                        <tr class="record-details" data-href="/classes/{{ $class->Class_Id }}">
                            <td>{{$count++}}</td>
                            <td>{{$class->course->Code}}: {{ $class->course->Title }}</td>
                            <td>{{$class->professor->LastName . ', ' . $class->professor->FirstName . ' ' . $class->professor->MiddleName}}</td>
                            <td>{{($class->section != null) ? $class->section->Code . ' ' . $class->section->AcademicYearStart . ' - ' . $class->section->AcademicYearEnd : ''}}</td>
                            <td class="td-fit">
                                {{ Form::open(array('url' => '/classes/' . $class->Class_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                <a href="/classes/{{ $class->Class_Id }}/edit" class="btn btn-warning" aria-hidden="true">
                                    <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                </a>
                                <button type="submit" class="btn btn-danger button-delete" aria-hidden="true">
                                    <span class="fa fa-remove"></span> Delete
                                </button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

                <!--<editor-fold desc="Class Data Table Script">-->
                <script>
                    $(document).ready(function() {
                        $('#ClassTable').DataTable();
                    } );
                </script>
                <!--</editor-fold>-->

            </div>
        </div>

    </div>
</div>
@endsection