@extends('layouts.master')
@section('body')


@include('includes.loader')
<div class="container center-block">
    {{ Form::open(array('action' => array('EventController@populateGuestList', $event->Event_Id), 'method' => 'post')) }}
        <div>
            <h1>{{$event->Event_Name}}</h1><br/>
        </div>
        <div class="form-group">
            <select multiple="multiple" id="inputs" size="10" name="students[]">
                @foreach($students as $student)
                    <option value="{{ $student->Student_Id }}" {{ ($student->events()->get()->contains($event)) ? 'selected=selected' : '' }}>{{$student->StudentNumber}}: {{$student->LastName}}, {{$student->FirstName}}</option>
                @endforeach
            </select>
        </div>
        <a href="/organization" class="btn btn-default align-right">Back</a>
        <button type="submit" class="btn btn-primary align-right">Submit</button>
    {{ Form::close() }}
</div>
<script>
    var GuestList = $('select[name="students[]"]').DualListbox();
</script>
@endsection