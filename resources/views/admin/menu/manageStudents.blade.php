@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Manage Students
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-users"></i> Manage Users
                        </li>
                        <li class="active">
                            <i class="fa fa-male"></i> Students
                        </li>
                    </ol>
                </div>
            </div><!-- row -->

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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($students as $student)
                            <tr>
                                <td class="hidden">{{$student->Student_Id}}</td>
                                <td><?php echo $count; $count++;?></td>
                                <td>{{$student->LastName}}, {{$student->FirstName}} {{$student->MiddleName}}</td>
                                <td>{{$student->Phone}}</td>
                                <td>{{$student->Email}}</td>
                                <td>{{\Carbon\Carbon::parse($student->Birthday)->format('M d, Y')}}</td>
                                <td>
                                    <a href="edit_professor/{{$student->Student_Id}}" id="edit" class=" btn btn-warning" role="button">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="deleteProfessor({{ $student->Student_Id }})">Delete&nbsp;<span class="fa fa-remove"></span></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function() {
                            $('#ProfTable').DataTable();
                        } );
                    </script>
                </div>
            </div><!-- Professor table row -->

            <button class="btn btn-success" data-toggle="modal" data-target="#addProfessor">
                <i class="fa fa-user-plus" aria-hidden="true"></i> Add Professor
            </button>

        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for adding professor">-->
        <div class="modal fade" id="addProfessor" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add Professor</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('action' => 'AdminController@addProfessor', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <div class="form-group">
                                <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                                <div class="col-lg-6">
                                    <input class="form-control input-md" id="FirstName" name="FirstName" placeholder="FirstName" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="MiddleName" class="col-lg-4 control-label" >Middle Name</label>
                                <div class="col-lg-6">
                                    <input class="form-control input-md" id="MiddleName" name="MiddleName" placeholder="MiddleName" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="LastName" class="col-lg-4 control-label" >Last Name</label>
                                <div class="col-lg-6">
                                    <input class="form-control input-md" id="LastName" name="LastName" placeholder="LastName" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Birthday" class="col-lg-4 control-label" >Birthday</label>
                                <div class="col-lg-6">
                                    <input class="form-control input-md" id="Birthday" name="Birthday" placeholder="Birthday" type="date" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Phone" class="col-lg-4 control-label" >Contact Number</label>
                                <div class="col-lg-6">
                                    <input class="form-control input-md" id="Phone" name="Phone" placeholder="Phone" type="number" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Email" class="col-lg-4 control-label" >Email</label>
                                <div class="col-lg-6">
                                    <input class="form-control input-md" id="Email" name="Email" placeholder="Email" type="email" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2 text-right">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                    <button type="reset" class="btn btn-info">Clear Form</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </fieldset>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!--</editor-fold>-->

    </div><!-- page-wrapper -->

@endsection