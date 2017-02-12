<script>
    $(document).ready(function(){
        $('#StudentTable').dataTable( );
    });
</script>

{{--Header--}}
<div class="row">
    <div>
        <h4>{{ $organization->Organization_Name }}</h4>
        @if($organization->Description)
            <h7>{{ $organization->Description }}</h7>
        @endif
    </div>
    {{--<div class="col-lg-4" style="text-align: right">--}}
        {{--<button type="button" class="btn btn-default" >Edit&nbsp;<span class="glyphicon glyphicon-pencil"></span></button>--}}
        {{--<button type="button" class="btn btn-danger">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>--}}
    {{--</div>--}}
</div>
{{--/Header--}}

<hr/>

<ul class="nav nav-tabs" style="margin-bottom: 10px;">
    <li class="active in"><a href="#members" data-toggle="tab">Members</a></li>
    <li><a href="#events" data-toggle="tab">Events</a></li>
</ul>

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="members">
        <table id="StudentTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th class="hide-column">Id</th>
                <th>Student Number</th>
                <th>Name</th>
                <th>Contact Num</th>
                <th>Email</th>
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="events">
        @foreach($events->chunk(3) as $eventChunks)
            <div class="custom-flexbox">
                @foreach($eventChunks as $event)
                    <div class="col-lg-4">
                        <div class="panel panel-primary text-center flex-content" style="position: relative; overflow: hidden">
                            <div class="panel-heading" style="min-height: 60px; max-height: 60px;">{{ $event->Event_Name }}</div>
                            <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                                <p id="test">Venue : {{ $event->Venue }}</p>
                                <p>From : {{ $event->Start_Time }}</p>
                                <p>To : {{ $event->End_Time }}</p>
                                <p>{{ $event->Description }}</p>
                            </div>
                            <div class="panel-footer">
                                <a href="guest_list/{{$event->Event_Id}}" role="button" class="btn btn-primary btn-block" style="margin-bottom: 5px" id="GuestList">Guest List</a>
                                <button class="btn btn-primary btn-block" id="{{ $event->Event_Id }}" onclick="getAttendanceList(this)">View Attendance</button>
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