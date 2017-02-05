{{--Header--}}
<div class="row">
    <div class="col-lg-8">
        <h4>{{ $organization->Organization_Name }}</h4>
        @if($organization->Description)
            <h7>{{ $organization->Description }}</h7>
        @endif
    </div>
    <div class="col-lg-4" style="text-align: right">
        <button type="button" class="btn btn-default" >Edit&nbsp;<span class="glyphicon glyphicon-pencil"></span></button>
        <button type="button" class="btn btn-danger">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
    </div>
</div>
{{--/Header--}}

<hr/>

<ul class="nav nav-tabs" style="margin-bottom: 10px;">
    <li class="active in"><a href="#members" data-toggle="tab">Members</a></li>
    <li><a href="#events" data-toggle="tab">Events</a></li>
</ul>

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="members">

    </div>
    <div class="tab-pane fade" id="events">
        @foreach($events->chunk(3) as $eventChunks)
            <div class="custom-flexbox">
                @foreach($eventChunks as $event)
                    <div class="col-lg-4" style="border: black 1px solid;">
                        <div class="panel panel-primary flex-content">
                            <div class="panel-heading">{{ $event->Event_Name }}</div>
                            <div class="panel-body">
                                <p id="test">Venue : {{ $event->Venue }}</p>
                                <p>From : {{ $event->Start_Time }}</p>
                                <p>To : {{ $event->End_Time }}</p>
                                <p>{{ $event->Description }}</p>
                                <button class="btn btn-primary center-block" id="{{ $event->Event_Id }}" onclick="getAttendanceList(this)">View Attendance</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<div id="attendanceList">
</div>