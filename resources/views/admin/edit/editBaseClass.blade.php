@extends('admin.layout.adminLayout')
@section('body')

    <div id="page-wrapper">
        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-edit"></b> Add Class
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> <a href="/classes"> Classes</a>
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> <a href="/courses/{{ $baseClass->course->Course_Id }}">{{ $baseClass->course->Code }}</a>
                        </li>
                        <li>
                            <i class="fa fa-edit"></i> {{ $baseClass->professor->LastName }}, {{ substr($baseClass->professor->FirstName, 0,1) }}.
                        </li>
                        <li class="active">
                            <i class="fa fa-edit"></i> Edit Class
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            {{ Form::open(array('url' => '/classes/' .  $baseClass->BaseClass_Id , 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
            <fieldset>
                <div class="col-lg-5">
                    <!--<editor-fold desc="Courses list">-->
                    <div class="form-group">
                        <label for="CoursesList" class="control-label col-lg-4">Select Course</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="CoursesList" name="CoursesList" disabled required>
                                    <option value="{{ $baseClass->course->Course_Id}}">
                                        {{ $baseClass->course->Code }}
                                    </option>
                            </select>
                        </div>
                    </div>
                    <!--</editor-fold>-->

                    <!--<editor-fold desc="Professors list">-->
                    <div class="form-group">
                        <label for="ProfessorsList" class="col-lg-4 control-label">Select Professor</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="ProfessorsList" name="ProfessorsList" disabled required>
                                    <option value="{{ $baseClass->professor->Professor_Id }}">
                                        {{ $baseClass->professor->LastName. ", " . $baseClass->professor->FirstName . " " . $baseClass->professor->MiddleName}}
                                    </option>
                            </select>
                        </div>
                    </div>
                    <!--</editor-fold>-->
                </div>

                <div class="col-lg-7">
                    <div class="form-group">
                        <select id="sectionsList" multiple="multiple" name="sectionsList[]">
                            @foreach($sections as $section)
                                <option value="{{ $section->Section_Id}}" {{ $baseClass->classes->contains($section)? 'selected="selected"' : '' }}>
                                    {{ $section->Code }} A.Y. {{ $section->AcademicYearStart }} - {{ $section->AcademicYearEnd }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#sectionsList').bootstrapDualListbox({
                                nonSelectedListLabel: 'All Sections',
                                selectedListLabel: 'Selected Outcome/s',
                                preserveSelectionOnMove: false,
                                moveOnSelect: true,
                                nonSelectedFilter: '{{ \Carbon\Carbon::now()->year }} - {{ \Carbon\Carbon::now()->year + 1 }}',
                            });
                        });
                    </script>
                </div>

                <div class="col-lg-12">
                    <hr />
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button id="reset-button" type="reset" class="btn btn-info">Clear Form</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </fieldset>
            {{ Form::close() }}

        </div>
    </div>

@endsection