@extends('layouts.master')
@section('body')

<script>
    $(document).ready(function(){
        $('#navAdmin').addClass("active");
    });
</script>

@include('adminpages.navlinks')

<script>
    $(document).ready(function(){
        $('#pillStudents').addClass("active");
    });
</script>

<table class="table table-hover table-condensed table-responsive">
    <tr>
        <th>Student Number</th>
        <th>First Name</th>
        <th>Last Name</th>
    </tr>
    @foreach($students as $student)
        <tr>
            <td>{{ $student->StudentNumber }}</td>
            <td>{{ $student->FirstName }}</td>
            <td>{{ $student->LastName }}</td>
        </tr>
    @endforeach
</table>

@endsection