@extends('professor.layout.professorLayout')

@section('body')

    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-edit"></b> {{ $course->Code }}: {{ $course->Title }}
                        <div class="pull-right">
                            {{ Form::open(array('url' => '/class/' . $class->Class_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                            <a href="/class/{{ $class->Class_Id }}/edit" class="btn btn-lg btn-warning" aria-hidden="true">
                                <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                            </a>
                            <button type="submit" class="btn btn-lg btn-danger button-delete" aria-hidden="true">
                                <span class="fa fa-remove"></span> Delete
                            </button>
                            {{ Form::close() }}
                        </div>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-book"></i> <a href="/pcourses/{{Auth::user()->id}}">Courses</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> <a href="/pcourses/{{Auth::user()->id}}">{{ $course->Code }}</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> {{ $course->Code }}
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            <div class="row">
                <div class="col-lg-12">
                    {{ Form::open(array('url' => '/updatescores/' . $class->Class_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                    <table id="ClassTable1" class="table table-hover table-condensed table-responsive table-bordered compact nowrap" width="100%" cellspacing="0">

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
                                @foreach($student->requirements()->where('Term', '=', 1)->get() as $requirement)
                                    <td class="td-fit">
                                        <input type="hidden"  name="Score[]" value="{{$requirement->pivot->id}}"/>
                                        <input type="number" class="form-control" name="{{$requirement->pivot->id}}" value="{{$requirement->pivot->Score}}" min="0" max="{{$requirement->HPS}}"/>
                                    </td>
                                @endforeach
                                <td class="td-fit">
                                    {{$student->pivot->PrelimGrade}}
                                </td>
                                @foreach($student->requirements()->where('Term', '=', 2)->get() as $requirement)
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
                            $('#ClassTable1').DataTable();
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