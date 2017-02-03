@extends('layouts.master')
@section('body')

<script>
    $(document).ready(function(){
        $('#navAdmin').addClass("active");
    });
</script>

@include('adminpages.navlinks')

<script>
    $(document).ready(function(){
        $('#pillStudents').addClass("active");
    });

    $(document).ready(function(){
        $('#StudentTable').dataTable( );
    });
</script>

<div>
    <table id="StudentTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="hide-column">Id</th>
                <th>Student Number</th>
                <th>Name</th>
                <th>Contact Num</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td class="hide-column">{{ $student->Student_Id }}</td>
                <td>{{ $student->StudentNumber }}</td>
                <td>{{ $student->LastName }}, {{ $student->FirstName }}</td>
                <td>{{ $student->Phone }}</td>
                <td>{{ $student->PersonalEmail }}</td>
                <td>
                    <a href="#" class=" btn btn-warning" data-toggle="modal" data-target="#editStudent" role="button" >
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteStudent({{$student->Student_Id}})">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#addStudent" role="button">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add User
    </a>
</div>

<!--<editor-fold desc="Modal for edit students">-->
<div class="modal" id="editStudent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body…
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--</editor-fold>-->

<!--<editor-fold desc="Modal for adding student">-->
<div class="modal" id="addStudent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add Student</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('action' => 'AdminController@addStudent', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="StudentNumber" class="col-md-4 control-label" >Student Number</label>
                            <div class="col-md-6">
                                <input class="form-control input-md" id="StudentNumber" name="StudentNumber" placeholder="StudentNumber" type="text" required>
                            </div>
                        </div>

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
                            <label for="Nickname" class="col-lg-4 control-label" >Nickname</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Nickname" name="Nickname" placeholder="Nickname" type="text"/>
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
                            <label for="PersonalEmail" class="col-lg-4 control-label" >Email</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="PersonalEmail" name="PersonalEmail" placeholder="PersonalEmail" type="email" required/>
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




@endsection