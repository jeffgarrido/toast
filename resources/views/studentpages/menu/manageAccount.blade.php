@extends('studentpages.layout.studentLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-child"></i> Personal Information
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-dashboard"></i> Personal Information
                        </li>
                    </ol>
                </div>
            </div><!-- row -->
            @if($errors->any())
                <div class="alert alert-success alert-dismissable fade in" id="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{--//<strong>Successfully</strong> added a new student!--}}
                    <strong>{{$errors->first()}}</strong>
                </div>
            @endif
            <script>
                $("#alert").fadeTo(8000, 500).slideUp(500, function(){
                    $("#alert").slideUp(500);
                });
            </script>
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="page-header">Personal Information</h3>
                </div>
                <div class="col-lg-6 pull-right">
                    <h3 class="page-header">Account Information</h3>
                </div>
            </div>
            {{ Form::open(array('url' => '/accounts', 'method' => 'POST', 'class' => 'form-horizontal')) }}
            {{csrf_field()}}
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                    <p><i>Complete to make changes</i></p><br>
                    <p>First Name:  <span style="margin-left: 10ch">{{$student->FirstName}}</span></p><br>
                    <p>Last Name:  <span style="margin-left: 10ch">{{$student->LastName}}</span></p><br>
                    <p>Personal Email:  <input class="pull-right" style="width: 25ch" type="email" id="email" name="email" value="{{$student->PersonalEmail}}"></p><br>
                    <p>Contact Number:  <input class="pull-right" style="width: 25ch" type="number" id="phone" name="phone" value="{{$student->Phone}}"></p>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4">
                    <p><i>Complete to make changes</i></p><br>
                    <input name="Student_Id" type="hidden" value="{{$student->Student_Id}}">
                    <input name="invisible" type="hidden" value="{{$user->id}}">
                    <p>*   Password:  <input class="pull-right" style="width: 25ch" type="password" id="pass" name="pass"></p><br>
                    <p>*   Verify Password:  <input class="pull-right" style="width: 25ch" type="password" id="pass2" name="pass2"></p>
                    <br><br>    <br>
                    <button type="submit" class="btn btn-primary pull-right">Save changes</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <hr>

                </div>
            </div>
            {{ Form::close() }}

@endsection

@section('organizations')
    @foreach($organizations as $org)
        <li>
            <a href="/organizations/{{$org->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$org->Organization_Name}}</a>
        </li>
    @endforeach
@endsection