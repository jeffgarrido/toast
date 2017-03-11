@extends('studentpages.layout.studentLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-connectdevelop"></i>{{$org->Description}} <small>({{$status}})</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </li>
                        <li class="active">
                            <i class="fa fa-users"></i> My Organization
                        </li>
                        <li class="active">
                            <i class="fa fa-connectdevelop"></i> {{$org->Organization_Name}}
                        </li>
                    </ol>
                </div>
            </div><!-- row -->
            <div class="row">
                <div class="col-lg-12 page-header" style="margin-top: -2ch">
                    <h3>Announcements</h3>
                </div>
                <div class="col-lg-12 page-header">
                    <h3>Events</h3>
                </div>
                <div class="col-md-12">
                    <div class="tab-pane" id="events">
                        @foreach($events->chunk(3) as $eventChunks)
                            <div class="custom-flexbox">
                                @foreach($eventChunks as $event)
                                    <div class="col-lg-4">
                                        <div class="panel panel-primary text-center flex-content" style="position: relative; overflow: hidden">
                                            <div class="panel-heading" style="min-height: 60px; max-height: 60px;"><h4>{{ $event->Event_Name }}</h4></div>
                                            <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                                                <p id="test">Venue : {{ $event->Venue }}</p>
                                                <p>Date : {{ $event->Event_Date }}</p>
                                                <p>From : {{ $event->Start_Time }}</p>
                                                <p>To : {{ $event->End_Time }}</p>
                                                <p>{{ $event->Description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

@endsection

@section('organizations')
    @foreach($organizations as $organization)
        <li>
            <a href="/organizations/{{$organization->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$organization->Organization_Name}}</a>
        </li>
    @endforeach
@endsection