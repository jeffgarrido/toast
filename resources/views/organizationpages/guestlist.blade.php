@extends('layouts.master')
@section('body')

@include('includes.loader')

<div class="jumbotron">
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
            <a href="/organization" class="btn btn-default align-right">Back</a>
            <button type="submit" class="btn btn-primary align-right">Save Changes</button>
        </div>
    {{ Form::close() }}
</div>

<script>
    $('#guestList').bootstrapDualListbox({
        nonSelectedListLabel: 'Student/s',
        selectedListLabel: 'Guest/s',
        preserveSelectionOnMove: false,
        moveOnSelect: true,
    });
</script>
@endsection