@extends('admin.layout.adminLayout')
@section('body')

    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-edit"></b> Manage Classes
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> Manage Classes
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> <a href="/classes">All Classes</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> {{ $class->course->Code }}
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

@endsection