@extends('layouts.master')
@section('body')

<div class="col-lg-3"></div>

<div class="col-lg-6 jumbotron">
    {{ Form::open(array('action' => array('AdminController@saveEditStudent', $student), 'method' => 'POST', 'class' => 'form-horizontal')) }}
    <fieldset>

        <div class="form-group">
            <label for="StudentNumber" class="col-lg-4 control-label">Student Number</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="StudentNumber" name="StudentNumber"  placeholder="Student Number" value="{{$student->StudentNumber}}">
            </div>
        </div>

        <div class="form-group">
            <label for="StudentNumber" class="col-md-4 control-label" >Academic Status</label>
            <div class="col-md-6">
                <select class="form-control input-md" id="AcademicStatus" name="AcademicStatus" required>
                    <option value="regular" {{ (strcasecmp($student->AcademicStatus, 'regular') == 0) ? 'selected="selected"' : '' }}>Regular</option>
                    <option value="irregular" {{ (strcasecmp($student->AcademicStatus, 'irregular') == 0) ? 'selected="selected"' : '' }}>Irregular</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="FirstName" class="col-lg-4 control-label">First Name</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="First Name" value="{{$student->FirstName}}">
            </div>
        </div>

        <div class="form-group">
            <label for="MiddleName" class="col-lg-4 control-label">Middle Name</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="MiddleName" name="MiddleName" placeholder="Middle Name" value="{{$student->MiddleName}}">
            </div>
        </div>

        <div class="form-group">
            <label for="LastName" class="col-lg-4 control-label">Last Name</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Last Name" value="{{$student->LastName}}">
            </div>
        </div>

        <div class="form-group">
            <label for="Nickname" class="col-lg-4 control-label">Nickname</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="Nickname" name="Nickname" placeholder="Nickname" value="{{$student->Nickname}}">
            </div>
        </div>

        <div class="form-group">
            <label for="Birthday" class="col-lg-4 control-label">Birthday</label>
            <div class="col-lg-8">
                <input type="date" class="form-control" id="Birthday" name="Birthday" placeholder="Birthday" value="{{$student->Birthday}}">
            </div>
        </div>

        <div class="form-group">
            <label for="Phone" class="col-lg-4 control-label">Contact No</label>
            <div class="col-lg-8">
                <input type="number" class="form-control" id="Phone" name="Phone" placeholder="Contact No" value="{{$student->Phone}}">
            </div>
        </div>

        <div class="form-group">
            <label for="PersonalEmail" class="col-lg-4 control-label">Email</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="PersonalEmail" name="PersonalEmail" placeholder="Email" value="{{$student->PersonalEmail}}">
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



<div class="col-lg-3"></div>



@endsection