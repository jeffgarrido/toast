@extends('layouts.master')
@section('body')


@include('includes.loader')
<div class="container center-block">
    <form id="demoform" action="#" method="post">
        <div>
            <h1>{{$event->Event_Name}}</h1><br/>
        </div>
        <div class="form-group">
            <select multiple="multiple" id="inputs" size="10" name="students">
                @foreach($student as $students)
                <option>{{$students->StudentNumber}}: {{$students->LastName}}, {{$students->FirstName}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
<script>
    var demo1 = $('select[name="students"]').bootstrapDualListbox();
    $("#demoform").submit(function() {alert($('[name="students"]').val());
        return false;
    });
</script>
@endsection