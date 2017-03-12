@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper" style="margin-top: -5ch">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Manage Oranizations
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-users"></i> Manage Users
                        </li>
                        <li class="active">
                            <i class="fa fa-child"></i> Organizations
                        </li>
                    </ol>
                </div>
                <div class="col-lg-12">
                    {{ Form::open(array('action' => array('EventController@populateGuestList', $event->Event_Id), 'method' => 'post')) }}
                    <div>
                        <h1>{{$event->Event_Name}}</h1><br/>
                    </div>
                    <div class="form-group">
                        <select multiple="multiple" id="guestList" size="10" name="guestList[]">
                            @foreach($students as $student)
                                <option value="{{ $student->Student_Id }}" {{ ($student->events()->get()->contains($event)) ? 'selected=selected' : '' }}>{{$student->StudentNumber}}: {{$student->LastName}}, {{$student->FirstName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="center-block align-right">
                        <a href="#" onclick="goBack()" class="btn btn-default align-right">Back</a>
                        <button type="submit" class="btn btn-primary align-right">Save Changes</button>
                    </div>
                    {{ Form::close() }}

                </div>
            </div><!-- row -->
        </div>
    </div>
    <script>
        $('#guestList').bootstrapDualListbox({
            nonSelectedListLabel: 'Student/s',
            selectedListLabel: 'Guest/s',
            preserveSelectionOnMove: false,
            moveOnSelect: true,
        });

        function goBack() {
            window.history.back();}
    </script>
@endsection