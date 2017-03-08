@extends('layouts.master')
@section('body')

@include('includes.loader')

    <div class="jumbotron">
        {{ Form::open(array('action' => array('AdminController@populateMemberList', $organization->Organization_Id), 'method' => 'post')) }}
        <div>
            <h2>{{$organization->Description}}</h2><br/>
        </div>
        <div class="form-group">
            <select multiple="multiple" id="memberList" size="10" name="memberList[]">
                @foreach($students as $student)
                    <option value="{{ $student->Student_Id }}" {{ ($student->organizations()->get()->contains($organization)) ? 'selected=selected' : '' }}>{{$student->StudentNumber}}: {{$student->LastName}}, {{$student->FirstName}}</option>
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
        $('#memberList').bootstrapDualListbox({
            nonSelectedListLabel: 'Student/s',
            selectedListLabel: 'Members/s',
            preserveSelectionOnMove: false,
            moveOnSelect: true,
        });
    </script>

@endsection