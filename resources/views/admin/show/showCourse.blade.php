@extends('admin.layout.adminLayout')

@section('body')

<div id="page-wrapper">

    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-book"></b> {{ $course->Code }}: {{ $course->Title }}

                    <div class="pull-right">
                        {{ Form::open(array('url' => '/courses/' . $course->Course_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                        <a href="/courses/{{ $course->Course_Id }}/edit" class="btn btn-lg btn-warning" aria-hidden="true">
                            <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                        </a>
                        <button type="submit" class="btn btn-lg btn-danger button-danger" aria-hidden="true">
                            <span class="fa fa-remove"></span> Delete
                        </button>
                        {{ Form::close() }}
                    </div>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-book"></i> <a href="/courses"> Courses</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-book"></i> {{ $course->Code }}
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12 bottom-pad">
                <a href="/requirements/{{ $course->Course_Id }}" class="btn btn-success pull-right" aria-hidden="true">
                    <span class="fa fa-search" aria-hidden="true"></span> Manage Requirements
                </a>
            </div>
            <div class="col-lg-12">
                <table id="CourseTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="th-fit">No.</th>
                        <th>Professor</th>
                        <th class="th-fit">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($course->professors()->get() as $professor)
                            <tr class="record-details" data-href="/classes/{{ $professor->pivot->BaseClass_Id }}">
                                <td class="td-fit">{{ $loop->iteration }}</td>
                                <td>{{$professor->LastName}}, {{$professor->FirstName}} {{$professor->MiddleName}}</td>
                                <td class="td-fit">
                                    {{ Form::open(array('url' => '/classes/' . $professor->pivot->BaseClass_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                    <a href="/classes/{{ $professor->pivot->BaseClass_Id }}/edit" class="btn btn-warning" aria-hidden="true">
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

                <script>
                    $(document).ready(function() {
                        $('#CourseTable').DataTable();
                    } );
                </script>
            </div>
        </div>
    </div><!-- container fluid -->
</div><!-- page-wrapper -->

@endsection