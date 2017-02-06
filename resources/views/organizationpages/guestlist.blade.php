@extends('layouts.master')
@section('body')


@include('includes.loader')
<div class="container center-block">
    <form id="demoform" action="/populateguestlist" method="post">
        <div>
            <h1>{{$event->Event_Name}}</h1><br/>
        </div>
        <div class="form-group">
            <select multiple="multiple" id="inputs" size="10" name="students[]">
                @foreach($students as $student)
                    <option value="{{ $student->Student_Id }}" {{ $events->contains($student) ? 'selected=selected' : '' }}>{{$student->StudentNumber}}: {{$student->LastName}}, {{$student->FirstName}}</option>
                @endforeach
            </select>
        </div>
        <a href="/organization" class="btn btn-default align-right">Back</a>
        <button type="submit" class="btn btn-primary align-right">Submit</button>
    </form>
</div>
<script>
    var GuestList = $('select[name="students"]').bootstrapDualListbox({
        nonSelectedListLabel: 'All Students',
        selectedListLabel: 'Guest List',
        moveOnSelect: false
    });
//    var demo1 = $('select[name="students"]').bootstrapDualListbox();
//    $("#demoform").submit(function() {alert($('[name="students"]').val());
//        return false;
//    });
</script>
@endsection