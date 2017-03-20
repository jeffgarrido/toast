{{--Attendance List Modal--}}
<div class="modal fade" id="attendanceListModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">Attendance List: {{ $event->Event_Name }}</h3>
            </div>
            <div class="modal-body">
                <table id="attendanceTable" class="table table-hover table-condensed table-responsive table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Student Number</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Time of Arrival</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->students()->where('event_student.Attendance', '<>', 0)->get() as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->StudentNumber }}</td>
                            <td>{{ $student->LastName }}</td>
                            <td>{{ $student->FirstName }}</td>
                            <td>{{ $student->pivot->Attendance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--/Attendance List Modal--}}