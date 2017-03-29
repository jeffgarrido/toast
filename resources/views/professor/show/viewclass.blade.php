@extends('professor.layout.professorLayout')

@section('body')

    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-users"></b> {{ $section->Code }}: {{ $course->Title }}
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-book"></i> <a href="/pcourses/{{Auth::user()->id}}">Courses</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> <a href="/pclasses/{{ $course->Course_Id }}"> {{ $course->Title }}</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-users"></i> {{ $section->Code }}
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{ Form::open(array('url' => '/pclasses/' . $class->Class_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                    <table id="ClassTable" class="table table-hover table-condensed table-responsive table-bordered compact nowrap" width="100%" cellspacing="0">

                        <!--<editor-fold desc="Class Table Head">-->
                        <thead>
                        <tr>
                            <th class="th-fit">Student #</th>
                            <th>Name</th>
                            @foreach($class->baseClass->requirements()->where('Term', '=', 1)->get() as $requirement)
                                <th class="th-fit">{{$requirement->Name}}</th>
                            @endforeach
                            <th class="th-fit">PG</th>
                            @foreach($class->baseClass->requirements()->where('Term', '=', 2)->get() as $requirement)
                                <th class="th-fit">{{$requirement->Name}}</th>
                            @endforeach
                            <th class="th-fit">FG</th>
                            <th class="th-fit">SG</th>
                            <th class="th-fit">TG</th>
                        </tr>
                        </thead>
                        <!--</editor-fold>-->

                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td class="td-fit">{{$student->StudentNumber}}</td>
                                <td>{{$student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName}}</td>
                                @foreach($student->requirements->filter(function($requirement) { return $requirement->Term == 1; }) as $requirement)
                                    <td class="td-fit">
                                        <input type="hidden"  name="Score[]" value="{{$requirement->pivot->id}}"/>
                                        <input type="number" class="form-control" name="{{$requirement->pivot->id}}" value="{{$requirement->pivot->Score}}" min="0" max="{{$requirement->HPS}}"/>
                                    </td>
                                @endforeach
                                <td class="td-fit">
                                    {{$student->pivot->PrelimGrade}}
                                </td>
                                @foreach($student->requirements->filter(function($requirement) { return $requirement->Term == 2; }) as $requirement)
                                    <td class="td-fit">
                                        <input type="hidden"  name="Score[]" value="{{$requirement->pivot->id}}"/>
                                        <input type="number" class="form-control" name="{{$requirement->pivot->id}}" value="{{$requirement->pivot->Score}}" min="0" max="{{$requirement->HPS}}"/>
                                    </td>
                                @endforeach
                                <td class="td-fit">
                                    {{$student->pivot->FinalGrade}}
                                </td>
                                <td class="td-fit">
                                    {{$student->pivot->SemestralGrade}}
                                </td>
                                <td class="td-fit">
                                    {{$student->pivot->TransmutedGrade}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    <!--<editor-fold desc="Class Data Table Script">-->
                    <script>
                        $(document).ready(function() {
                            $('#ClassTable').DataTable({
                                order: [1, 'asc'],
                                "scrollX": true
                            });
                        } );
                    </script>
                    <!--</editor-fold>-->

                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <hr/>
                        <div class="col-lg-10 col-lg-offset-2 text-right">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>

        </div>
    </div>

@endsection