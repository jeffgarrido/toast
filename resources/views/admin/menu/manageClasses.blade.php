@extends('admin.layout.adminLayout')
@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-edit"></b> Manage Classes
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> Manage Classes
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> All Classes
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12">
                <table id="ClassTable" class="table table-stripe table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                    <!--<editor-fold desc="Class Table Head">-->
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Course</th>
                        <th>Instructor</th>
                        <th>Section</th>
                        <th class="th-fit">Actions</th>
                    </tr>
                    </thead>
                    <!--</editor-fold>-->
                    <tbody>
                    <?php $count = 1;?>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$class->course->Code}}: {{ $class->course->Title }}</td>
                            <td>{{$class->professor->LastName . ', ' . $class->professor->FirstName . ' ' . $class->professor->MiddleName}}</td>
                            <td>{{($class->section != null) ? $class->section->Code : ''}}</td>
                            <td class="td-fit">
                                {{ Form::open(array('url' => '/classes/' . $class->Class_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                                <a href="/classes/{{ $class->Class_Id }}/edit" class="btn btn-warning" aria-hidden="true">
                                    <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                </a>
                                <button type="submit" class="btn btn-danger" aria-hidden="true">
                                    <span class="fa fa-remove"></span> Delete
                                </button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--<editor-fold desc="Class Data Table Script">-->
                <script>
                    $(document).ready(function() {
                        $('#ClassTable').DataTable();
                    } );
                </script>
                <!--</editor-fold>-->

            </div>
        </div>

        <!--<editor-fold desc="Add Class Button">-->
        <button class="btn btn-success" data-toggle="modal" data-target="#addClass">
            <i class="fa fa-user-plus" aria-hidden="true"></i> Add Class
        </button>
        <!--</editor-fold>-->

    </div>

    <!--<editor-fold desc="Add Class Modal">-->
    <div class="modal fade" id="addClass" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Add Class</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => '/classses', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="Code" class="col-lg-4 control-label" >Section Code</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="Code" name="Code" placeholder="" type="text" required/>
                            </div>
                        </div>

                        <?php $year = \Carbon\Carbon::now()->year ?>
                        <div class="form-group">
                            <label for="AcademicYearStart" class="col-lg-4 control-label" >Academic Year Start</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="AcademicYearStart" name="AcademicYearStart" placeholder="{{ $year }}" value="{{ $year }}" type="number" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="AcademicYearEnd" class="col-lg-4 control-label" >Academic Year End</label>
                            <div class="col-lg-7">
                                <input class="form-control input-md" id="AcademicYearEnd" name="AcademicYearEnd" placeholder="{{ $year + 1 }}" type="number" value="{{ $year+1 }}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2 text-right">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                <button type="reset" class="btn btn-info">Clear Form</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <!--</editor-fold>-->

</div>
@endsection