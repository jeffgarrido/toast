@extends('admin.layout.adminLayout')

@section('body')
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12" style="margin-top: -3ch">
                    <h1 class="page-header">
                        <i class="fa fa-fw fa-connectdevelop"></i>{{$org->Description}} <small>({{$org->Organization_Name}})</small>
                    </h1>
                </div>
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><i class="glyphicon glyphicon-home"></i></li>
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-child"></i> <a href="/organizations_admin">Organizations</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-connectdevelop"></i> {{$org->Organization_Name}}
                        </li>
                    </ol>
                </div>
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Announcements</a></li>
                        <li><a href="#eventss" data-toggle="tab" aria-expanded="true">Events</a></li>
                        <li><a href="#memberss" data-toggle="tab" aria-expanded="true">Members</a></li>
                        <li><a href="#staff" data-toggle="tab" aria-expanded="true">Staff</a></li>
                    </ul>
                </div>
            </div><!-- row -->
            <div id="myTabContent" class="tab-content">
                <div class="col-lg-12 tab-pane fade active in" id="home">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Announcements
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addAnnouncement">
                                <i class="fa fa-list-alt" aria-hidden="true"></i> Add Announcement
                            </button>
                        </h3>
                    </div>
                    @foreach($announcements as $announcement)
                    <div class="col-lg-12 row row-eq-height" style="margin-bottom: auto">
                            <div class="well well-sm col-lg-10" >
                                <strong><h4>{{$announcement->Title}}</h4></strong>
                                <p><font size="2">Date posted: {{date('F d, Y', strtotime($announcement->created_at))}}</font></p>
                                <hr>
                                <p>Content: {{$announcement->Announcement}}</p>
                            </div>
                            <div class="well well-sm col-lg-2" style="height: auto">
                                <p><font size="2">Posted by: {{$announcement->Uploaded_by}}</font></p>
                            </div>
                    </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="eventss">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Upcoming Events
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addEventModal">
                                <i class="fa fa-list-alt" aria-hidden="true"></i> Add Events
                            </button>
                        </h3>
                    </div>
                    <div class="col-md-12">
                        @foreach($events->chunk(3) as $eventChunks)
                            <div class="custom-flexbox">
                                @foreach($eventChunks as $event)
                                    @if ($event->Event_Date > date_format(new DateTime(), 'Y-m-d'))
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
                                                <div class="panel-footer">
                                                    {{--<a href="guest_list/{{$event->Event_Id}}" role="button" class="btn btn-primary btn-block" style="margin-bottom: 5px" id="GuestList">Guest List</a>--}}
                                                    <button class="btn btn-primary btn-block" id="{{ $event->Event_Id }}" onclick="getAttendanceList({{ $event->Event_Id }})">View Attendance</button>
                                                    <button class="btn btn-primary btn-block" onclick="editEventDetails({{ $event->Event_Id }})">Edit Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Past Events
                        </h3>
                    </div>
                    <div class="col-md-12">
                        @foreach($events->chunk(3) as $eventChunks)
                            <div class="custom-flexbox">
                                @foreach($eventChunks as $event)
                                    @if ($event->Event_Date < date_format(new DateTime(), 'Y-m-d'))
                                        <div class="col-lg-4">
                                            <div class="panel panel-danger text-center flex-content" style="position: relative; overflow: hidden">
                                                <div class="panel-heading" style="min-height: 60px; max-height: 60px;"><h4>{{ $event->Event_Name }}</h4></div>
                                                <div class="panel-body row" style="min-height: 180px; max-height: 60px; overflow-y: scroll; padding-left: 17px;">
                                                    <p id="test">Venue : {{ $event->Venue }}</p>
                                                    <p>Date : {{ $event->Event_Date }}</p>
                                                    <p>From : {{ $event->Start_Time }}</p>
                                                    <p>To : {{ $event->End_Time }}</p>
                                                    <p>{{ $event->Description }}</p>
                                                </div>
                                                <div class="panel-footer">
                                                    {{--<a href="/guest_list/{{$event->Event_Id}}" role="button" class="btn btn-danger btn-block" style="margin-bottom: 5px" id="GuestList">Guest List</a>--}}
                                                    <button class="btn btn-danger btn-block viewlist" onclick="getAttendanceList({{ $event->Event_Id }})">View Attendance</button>
                                                    <button class="btn btn-danger btn-block" onclick="editEventDetails({{ $event->Event_Id }})">Edit Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="memberss">
                    <div class="col-lg-12" >
                        <h3 class="page-header">
                            Members
                            <a href="/add_member/{{$org->Organization_Id}}" class="btn btn-success pull-right" >
                                <i class="fa fa-list-alt" aria-hidden="true"></i> Add Member
                            </a>
                        </h3>
                    </div>
                    <div class="col-lg-12">
                        <table id="memberList" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="hide-column">Id</th>
                                <th>No.</th>
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
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $student->StudentNumber }}</td>
                                    <td>{{ $student->LastName }}, {{ $student->FirstName }}</td>
                                    <td>{{ $student->Phone }}</td>
                                    <td>{{ $student->PersonalEmail }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                $('#memberList').DataTable( {
                                    "columnDefs": [
                                        { "searchable": false, "targets": 0},
                                        { "searchable": false, "targets": 1},
                                        { "searchable": false, "targets": 4},
                                        { "searchable": false, "targets": 5}
                                    ]
                                });
                            } );
                        </script>
                    </div>
                </div>
                <div class="tab-pane fade" id="staff">
                    <div class="col-lg-12" style="margin-top: -2ch">
                        <h3 class="page-header">
                            Staff Members
                            <button class="btn btn-success pull-right" onclick="editStaff({{$org->Organization_Id}})">
                                <i class="fa fa-users" aria-hidden="true"></i> Edit Staff
                            </button>
                        </h3>
                    </div>
                    <div class="col-lg-5" >
                        <div class="well well-sm">
                            <strong>Organization Adviser:</strong> {{$org->professors->FirstName}} {{$org->professors->MiddleName}} {{$org->professors->LastName}}
                        </div>

                            <div class="well well-sm">
                                <strong>President: </strong>@foreach($students as $student)@if($student->pivot->Position == 'President') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                            </div>
                            <div class="well well-sm">
                                <strong>Vice President: </strong>@foreach($students as $student)@if($student->pivot->Position == 'Vice President') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                            </div>
                            <div class="well well-sm">
                                <strong>Treasurer: </strong> @foreach($students as $student)@if($student->pivot->Position == 'Treasurer') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                            </div>
                            <div class="well well-sm">
                                <strong>Secretary: </strong>@foreach($students as $student)@if($student->pivot->Position == 'Secretary') {{$student->FirstName}} {{$student->MiddleName}} {{$student->LastName}}@endif @endforeach
                            </div>

                    </div>
                </div>
            </div>

        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

    <!--<editor-fold desc="Modal for editing professor">-->
    <div id="addEventWrapper"></div>
    <!--</editor-fold>-->

    <!--<editor-fold desc="Modal for adding Event">-->
    <div class="modal fade" id="addEventModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add new event</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => '/events/' . $org->Organization_Id , 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="Event_Name" class="col-md-4 control-label" >Event Name</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="Event_Name" name="Event_Name"  placeholder="IICS General Assembly" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Description" class="col-md-4 control-label" >Description</label>
                            <div class="col-lg-7">
                                <textarea class="input" cols="42" rows="4" placeholder="Short Description" name="Description"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Event_Date" class="col-md-4 control-label" >Event Date</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="Event_Date" name="Event_Date"  placeholder="ex. 2017-03-30" type="date" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Start_Time" class="col-md-4 control-label" >Event Time</label>
                            <div class="col-lg-3">
                                <input class="form-control input-md col-sm-3" id="Start_Time" name="Start_Time"  placeholder="ex. 23:59" type="time" required/>
                            </div>
                            <div class="col-lg-1">to</div>
                            <div class="col-lg-3">
                                <input class="form-control input-md col-sm-3" id="End_Time" name="End_Time"  placeholder="ex. 23:59" type="time" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Code" class="col-lg-4 control-label" >Student Outcomes</label>
                            <div class="col-lg-7">
                                <select class="form-control outcomeList" multiple="multiple" id="outcome" name="outcomeslist[]">
                                    @foreach($outcomes as $outcome)
                                        <option value="{{$outcome->Outcome_Id}}">{{ $outcome->Outcome_Code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Venue" class="col-md-4 control-label" >Venue</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="Venue" name="Venue"  placeholder="Medicine Auditorium" type="text" required/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Event</button>
                        </div>

                    </fieldset>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
    </div>
    <!--</editor-fold>-->

    <!--<editor-fold desc="Modal for adding Announcement">-->
    <div class="modal fade" id="addAnnouncement">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add announcement</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => '/organizations_admin/' . $org->Organization_Id , 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="Title" class="col-md-4 control-label" >Subject/Title</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="Title" name="Title"  placeholder="IICS General Assembly" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Announcement" class="col-md-4 control-label" >Content</label>
                            <div class="col-lg-7">
                                <textarea class="input" cols="42" rows="7" placeholder="Announcement content" name="Announcement" required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Announcement</button>
                        </div>

                    </fieldset>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
    </div>
    <!--</editor-fold>-->

    <!--<editor-fold desc="Modal for viewing attendance">-->
    <div id="editOrgWrapper"></div>
    <!--</editor-fold>-->

    <!--<editor-fold desc="Modal for editing staff">-->
    <div id="editStaffWrapper"></div>
    <!--</editor-fold>-->

    <script>
        $('.outcomeList').multiselect({
            maxHeight: 200,
            buttonWidth: '100%'
        });
    </script>
@endsection

