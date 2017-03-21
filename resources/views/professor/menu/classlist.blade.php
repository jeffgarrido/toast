@extends('professor.layout.professorLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-edit"></b> {{ $course->Code }}: {{ $course->Title }}
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-book"></i> <a href="/pcourses/{{Auth::user()->id}}">Courses</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> {{ $course->Code }}
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-right bottom-pad">
                    <a href="/pclasses/edit_requirements/{{$baseClass->BaseClass_Id}}" class="btn btn-success"><i class="fa fa-search"></i> View Requirements</a>
                </div>
                <div class="col-lg-12">
                    <table id="ClassTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">

                        <!--<editor-fold desc="Class Table Head">-->
                        <thead>
                        <tr>
                            <th class="th-fit">No.</th>
                            <th>Section</th>
                            <th>Academic Year</th>
                        </tr>
                        </thead>
                        <!--</editor-fold>-->

                        <tbody>
                        @foreach($baseclasses as $bc)
                            @foreach($bc->classes as $class)
                            <tr class="record-details-professor" data-href="/pclasses/{{$class->pivot->Class_Id}}/edit">
                                <td>{{$loop->iteration}}.</td>
                                <td>{{$class->Code}}</td>
                                <td>{{$class->AcademicYearStart}} - {{$class->AcademicYearEnd}}</td>
                            </tr>
                            @endforeach
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

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

@endsection