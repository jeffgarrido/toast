@extends('admin.layout.adminLayout')

@section('body')
    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-edit"></b> {{ $baseClass->course->Code }}: {{ $baseClass->course->Title }}
                        <div class="pull-right">
                            {{ Form::open(array('url' => '/classes/' . $baseClass->BaseClass_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                            <a href="/classes/{{ $baseClass->BaseClass_Id }}/edit" class="btn btn-lg btn-warning" aria-hidden="true">
                                <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                            </a>
                            <button type="submit" class="btn btn-lg btn-danger button-delete" aria-hidden="true">
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
                            <i class="fa fa-edit"></i> <a href="/classes"> Classes</a>
                        </li>
                        <li>
                            <i class="fa fa-book"></i> <a href="/courses/{{ $baseClass->course->Course_Id }}">{{ $baseClass->course->Code }}</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-male"></i> {{ $baseClass->professor->LastName }}, {{ substr($baseClass->professor->FirstName, 0,1) }}.
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            <div class="row">
                <div class="col-lg-12 text-right bottom-pad">
                    <a href="/requirements/{{$baseClass->BaseClass_Id}}" class="btn btn-success"><i class="fa fa-search"></i> View Requirements</a>
                </div>
                <div class="col-lg-12">
                    <table id="ClassTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">

                        <!--<editor-fold desc="Class Table Head">-->
                        <thead>
                            <tr>
                                <th class="th-fit">Section</th>
                                <th>Academic Year</th>
                                <th class="th-fit">Actions</th>
                            </tr>
                        </thead>
                        <!--</editor-fold>-->

                        <tbody>
                        @foreach($classes as $class)
                            <tr class="record-details" data-href="/class/{{ $class->pivot->Class_Id }}">
                                <td class="td-fit">{{$class->Code}}</td>
                                <td>{{$class->AcademicYearStart}} - {{$class->AcademicYearEnd}}</td>
                                <td class="td-fit">
                                    <div class="pull-right">
                                        {{ Form::open(array('url' => '/class/' . $class->pivot->Class_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                        <a href="/class/{{ $class->pivot->Class_Id}}/edit" class="btn btn-warning" aria-hidden="true">
                                            <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger button-delete" aria-hidden="true">
                                            <span class="fa fa-remove"></span> Delete
                                        </button>
                                        {{ Form::close() }}
                                    </div>
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