@extends('admin.layout.adminLayout')
@section('body')

<div id="page-wrapper">
    <div class="container-fluid">

        <!--<editor-fold desc="Page Header">-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <b class="fa fa-lg fa-server"></b> Manage Sections
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-edit"></i> Manage Classes
                    </li>
                    <li>
                        <i class="fa fa-server"></i> Manage Sections
                    </li>
                </ol>
            </div>
        </div>
        <!--</editor-fold>-->

        <div class="row">
            <div class="col-lg-12">
                <table id="SectionTable" class="table table-stripe table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                    <!--<editor-fold desc="Section Table Head">-->
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Section</th>
                        <th>Academic Year</th>
                        <th class="th-fit">Actions</th>
                    </tr>
                    </thead>
                    <!--</editor-fold>-->
                    <tbody>
                    <?php $count = 1;?>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$section->Code}}</td>
                            <td>{{$section->AcademicYearStart . ' - ' . $section->AcademicYearEnd}}</td>
                            <td class="td-fit">
                                {{ Form::open(array('url' => '/sections/' . $section->Section_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                                <button type="button" class="btn btn-warning" aria-hidden="true" onclick="editSectionDetails({{ $section->Section_Id }})">
                                    <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                </button>
                                <button type="submit" class="btn btn-danger" aria-hidden="true">
                                    <span class="fa fa-remove"></span> Delete
                                </button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--<editor-fold desc="Section Data Table Script">-->
                <script>
                    $(document).ready(function() {
                        $('#SectionTable').DataTable();
                    } );
                </script>
                <!--</editor-fold>-->

            </div>
        </div>

        <!--<editor-fold desc="Add Section Button">-->
        <button class="btn btn-success" data-toggle="modal" data-target="#addSection">
            <i class="fa fa-user-plus" aria-hidden="true"></i> Add Section
        </button>
        <!--</editor-fold>-->

    </div>

    <!--<editor-fold desc="Add Section Modal">-->
    <div class="modal fade" id="addSection" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add Section</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => '/sections', 'method' => 'POST', 'class' => 'form-horizontal')) }}
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

    <!--<editor-fold desc="Modal for editing section">-->
    <div id="editSectionWrapper"></div>
    <!--</editor-fold>-->

</div>

@endsection