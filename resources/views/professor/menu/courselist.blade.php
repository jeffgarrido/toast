@extends('professor.layout.professorLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-book"></b> Courses
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-book"></i> Courses
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->
            <div class="row">
                <div class="col-lg-12">
                    <table id="CourseTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Course Code</th>
                            <th>Title</th>
                            <th>Units</th>
                            <th>Description</th>
                            <th>Terms</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($courses as $course)
                            <tr class="record-details-professor" data-href="/pclasses/{{ $course->course->Course_Id }}">

                                <td class="hidden">{{$course->course->Course_Id}}</td>
                                <td>{{$count++}}</td>
                                <td>{{$course->course->Code}}</td>
                                <td>{{$course->course->Title}}</td>
                                <td>{{$course->course->Units}}</td>
                                <td>{{$course->course->Description}}</td>
                                <td>{{$course->course->Terms}}</td>

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

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

@endsection