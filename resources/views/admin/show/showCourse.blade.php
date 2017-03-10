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
                            {{ Form::open(array('url' => '/courses/' . $course->Course_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                            <a href="/courses/{{ $course->Course_Id }}/edit" class="btn btn-lg btn-warning" aria-hidden="true">
                                <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                            </a>
                            <button type="submit" class="btn btn-lg btn-danger" aria-hidden="true">
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
                            <i class="fa fa-book"></i> <a href="/courses">Manage Courses</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-book"></i> {{ $course->Code }}
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            <div class="row">
                <div class="col-lg-12">
                    <table id="ProfTable" class="table table-stripe table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Birthday</th>
                            <th class="th-fit">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($professors as $professor)
                            <tr>
                                <td class="hidden">{{$professor->Professor_Id}}</td>
                                <td><?php echo $count; $count++;?></td>
                                <td>{{$professor->LastName}}, {{$professor->FirstName}} {{$professor->MiddleName}}</td>
                                <td>{{$professor->Phone}}</td>
                                <td>{{$professor->Email}}</td>
                                <td>{{\Carbon\Carbon::parse($professor->Birthday)->format('M d, Y')}}</td>
                                <td class="td-fit">
                                    {{ Form::open(array('url' => '/professors/' . $professor->Professor_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                                    <button type="button" class="btn btn-warning" aria-hidden="true" onclick="editProfessorDetails({{ $professor->Professor_Id }})">
                                        <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                    </button>
                                    <button type="submit" class="btn btn-danger" aria-hidden="true">
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
                            $('#ProfTable').DataTable();
                        });
                    </script>
                </div>
            </div>

            <br/>
        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for editing courses">-->
        <div id="editCoursesWrapper"></div>
        <!--</editor-fold>-->


    </div><!-- page-wrapper -->

@endsection