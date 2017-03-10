@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-book"></b> Edit Course
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-book"></i> <a href="/courses">Manage Courses</a>
                        </li>
                        <li>
                            <i class="fa fa-book"></i> <a href="/courses/{{ $course->Course_Id }}">{{ $course->Code }}</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-pencil"></i> Edit
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            {{ Form::open(array('url' => '/courses', 'method' => 'POST', 'class' => 'form-horizontal')) }}
            <fieldset>

                <!--<editor-fold desc="Course Details Form">-->
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="Code" class="col-lg-4 control-label">Course Code</label>
                        <div class="col-lg-7">
                            <input class="form-control" id="Code" name="Code" placeholder="Course Code" value="{{ $course->Code }}" type="text" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Title" class="col-lg-4 control-label">Title</label>
                        <div class="col-lg-7">
                            <input class="form-control" id="Title" name="Title" placeholder="Course Title" value="{{ $course->Title }}" type="text" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Title" class="col-lg-4 control-label">Units</label>
                        <div class="col-lg-7">
                            <input class="form-control" id="Units" name="Units" placeholder="Number of Units" value="{{ $course->Units }}" type="number" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Terms" class="col-lg-4 control-label">Number of Terms</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="Terms" name="Terms" disabled required>
                                <option selected="selected">2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Description" class="col-lg-4 control-label">Description</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" rows="3" id="Description" name="Description" style="resize: vertical;"></textarea>
                            <span class="help-block">Note: Description is optional</span>
                        </div>
                    </div>
                </div>
                <!--</editor-fold>-->

                <div class="col-lg-7">
                    <div class="form-group">
                        <select id="outcomesList" multiple="multiple" name="outcomesList[]">
                            @foreach($outcomes as $outcome)
                                <option value="{{ $outcome->Outcome_Id}}">
                                    {{ $outcome->Outcome_Code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#outcomesList').bootstrapDualListbox({
                            nonSelectedListLabel: 'All Outcomes',
                            selectedListLabel: 'Selected Outcome/s',
                            preserveSelectionOnMove: false,
                            moveOnSelect: true,
                        });
                    });
                </script>

                <!--<editor-fold desc="Professors list and script">-->
                <div class="col-lg-7">
                    <div class="form-group">
                        <select id="professorsList" multiple="multiple" name="professorsList[]" required>
                            @foreach($professors as $professor)
                                <option value="{{ $professor->Professor_Id }}">
                                    {{ $professor->LastName. ", " . $professor->FirstName . " " . $professor->MiddleName}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#professorsList').bootstrapDualListbox({
                            nonSelectedListLabel: 'All Professors',
                            selectedListLabel: 'Selected Professor/s',
                            preserveSelectionOnMove: false,
                            moveOnSelect: true,
                        });
                    });
                </script>
                <!--</editor-fold>-->

                <div class="col-lg-12">
                    <hr />
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button type="reset" class="btn btn-info">Clear Form</button>
                            <button type="submit" class="btn btn-primary">Create Course</button>
                        </div>
                    </div>
                </div>
            </fieldset>
            {{ Form::close() }}

        </div>

    </div>

@endsection