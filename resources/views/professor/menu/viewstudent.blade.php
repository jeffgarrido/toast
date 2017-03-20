@extends('professor.layout.professorLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-users"></i>Student List
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Students
                        </li>
                    </ol>
                </div>
            </div><!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <table id="StudentTable" class="table table-stripe table-condensed table-responsive table-bordered compact" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Birthday</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($students as $student)
                            <tr>
                                <td class="hidden">{{$student->Student_Id}}</td>
                                <td>{{$count++}}</td>
                                <td>{{$student->LastName}}, {{$student->FirstName}} {{$student->MiddleName}}</td>
                                <td>{{$student->Phone}}</td>
                                <td>{{$student->PersonalEmail}}</td>
                                <td>{{\Carbon\Carbon::parse($student->Birthday)->format('M d, Y')}}</td>
                                <td>
                                    {{ Form::open(array('url' => '/students/' . $student->Student_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                    <button type="button" class="btn btn-warning" aria-hidden="true" onclick="editStudentDetails({{ $student->Student_Id }})">
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
                            $('#StudentTable').DataTable();
                        } );
                    </script>
                </div>
            </div>
        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

@endsection