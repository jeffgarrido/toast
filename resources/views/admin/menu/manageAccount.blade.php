@extends('admin.layout.adminLayout')
@section('body')

    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-edit"></b> Manage Account
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> Classes
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Edit Information</h3>
                </div>
            </div>
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
            {{ Form::open(array('url' => '/accounts', 'method' => 'POST', 'class' => 'form-horizontal')) }}
            {{csrf_field()}}
            <div class="row">
                <div class="col-lg-4">
                    <p><i>Complete to make changes</i></p><br>
                    <input name="invisible" type="hidden" value="{{$admin->id}}">
                    <p>Full name:  <input class="pull-right" style="width: 25ch" type="text" name="name" value="{{$admin->name}}" readonly></p><br>
                    <p>Email:  <input class="pull-right" style="width: 25ch" type="text" id="email" name="email" value="{{$admin->email}}" readonly></p><br>
                    <p>*   Password:  <input class="pull-right" style="width: 25ch" type="password" id="pass" name="pass"></p>
                    <p>*   Verify Password:  <input class="pull-right" style="width: 25ch" type="password" id="pass2" name="pass2"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection