@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper" style="margin-top: -5ch">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Manage Students
                        <button class="btn btn-lg btn-success pull-right" data-toggle="modal" data-target="#addStudent">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Add Student
                        </button>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-users"></i> Manage Users
                        </li>
                        <li class="active">
                            <i class="fa fa-child"></i> Students
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
                                    {{ Form::open(array('url' => '/students/' . $student->Student_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
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
            </div><!-- Professor table row -->


        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for adding student">-->
        <div class="modal fade" id="addStudent" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><span class="fa fa-fw fa-child" aria-hidden="true"></span> Add Student</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('url' => '/students', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <div class="form-group">
                                <label for="FirstName" class="col-md-4 control-label" >Student Number</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="StudentNumber" name="StudentNumber" placeholder="ex. 2017010203" type="number" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="AcademicStatus" class="col-md-4 control-label">Academic Status</label>
                                <div class="col-lg-7" id="AcademicStatusWrapper">
                                    <select class="form-control" id="AcademicStatus" name="AcademicStatus">
                                        <option value="Regular">Regular</option>
                                        <option value="Irregular">Irregular</option>
                                    </select>
                                    <script>
                                        $('#AcademicStatus').change(function() {
                                            if(this.value == 'Regular') {
                                                $('#Section').prop('disabled', false);
                                            } else {
                                                $('#Section').prop('disabled', true);
                                            }
                                        });
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Section" class="col-md-4 control-label">Section</label>
                                <div class="col-lg-7">
                                    <select class="form-control" id="Section" name="Section">
                                        <option disabled selected value> -- select a section -- </option>
                                        @foreach($sections as $section)
                                            <option value="{{$section->Section_Id}}">{{$section->Code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="FirstName" name="FirstName" placeholder="Given Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="MiddleName" class="col-lg-4 control-label" >Middle Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="MiddleName" name="MiddleName" placeholder="Mother's Maiden Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="LastName" class="col-lg-4 control-label" >Last Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="LastName" name="LastName" placeholder="Family Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Birthday" class="col-lg-4 control-label" >Birthday</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="Birthday" name="Birthday" placeholder="ex. 2017-02-14 (yyyy-mm-dd)" type="date" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Phone" class="col-lg-4 control-label" >Contact Number</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="Phone" name="Phone" placeholder="ex. 09123457789" type="number" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="PersonalEmail" class="col-lg-4 control-label" >Email</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="PersonalEmail" name="PersonalEmail" placeholder="Personal Email" type="email" required/>
                                    <span class="help-block">Note: Used for password reset.</span>
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

        <!--<editor-fold desc="Modal for editing student">-->
        <div id="editStudentWrapper"></div>
        <!--</editor-fold>-->


    </div><!-- page-wrapper -->

@endsection