@extends('studentpages.layout.studentLayout')

@section('body')

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-fw fa-dashboard"></i>Student Dashboard <small>Statistics Overview</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div><!-- row -->

    </div><!-- container fluid -->

</div><!-- page-wrapper -->

@endsection

@section('organizations')
    @foreach($organizations as $org)
        <li>
            <a href="/organizations/{{$org->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$org->Organization_Name}}</a>
        </li>
    @endforeach
@endsection