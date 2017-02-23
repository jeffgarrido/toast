@extends('layouts.basic')

@section('body1')

    <div class="col-lg-3"></div>

    <div class="col-lg-6 jumbotron">
        <div class="container">
            {{ Form::open(array('action' => array('AdminController@saveEditProfessor', $professor), 'method' => 'POST', 'class' => 'form-horizontal')) }}
            <fieldset>

                <div class="form-group">
                    <label for="FirstName" class="col-lg-4 control-label">First Name</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="First Name" value="{{$professor->FirstName}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="MiddleName" class="col-lg-4 control-label">Middle Name</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="MiddleName" name="MiddleName" placeholder="Middle Name" value="{{$professor->MiddleName}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="LastName" class="col-lg-4 control-label">Last Name</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Last Name" value="{{$professor->LastName}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Birthday" class="col-lg-4 control-label">Birthday</label>
                    <div class="col-lg-8">
                        <input type="date" class="form-control" id="Birthday" name="Birthday" placeholder="Birthday" value="{{$professor->Birthday}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Phone" class="col-lg-4 control-label">Contact No</label>
                    <div class="col-lg-8">
                        <input type="number" class="form-control" id="Phone" name="Phone" placeholder="Contact No" value="{{$professor->Phone}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="PersonalEmail" class="col-lg-4 control-label">Email</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="PersonalEmail" name="PersonalEmail" placeholder="Email" value="{{$professor->Email}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2" style="text-align: right">
                        <a href="/admin/" role="button" type="reset" class="btn btn-default">Cancel</a>
                        <button role="button" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-lg-3"></div>



@endsection