@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper" style="margin-top: -5ch">

        <div class="container-fluid">

            <!-- Page Heading -->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Manage Students
                        <button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#addStudent">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Add Student
                        </button>
                        <button class="btn btn-md btn-success pull-right" style="margin-right: 1ch" data-toggle="modal" data-target="#addBulk">
                            <i class="fa fa-users" aria-hidden="true"></i> Add Bulk
                        </button>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa fa-users"></i> Manage Users
                        </li>
                        <li class="active">
                            <i class="fa fa-child"></i> Students
                        </li>
                    </ol>
                    @if($errors->any())
                        <div class="alert alert-success alert-dismissable fade in" id="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Successfully</strong> added a new student!
                            {{--<h4>{{$errors->first()}}</h4>--}}
                        </div>
                        <script>
                            $("#alert").fadeTo(5000, 500).slideUp(500, function(){
                                $("#alert").slideUp(500);
                            });
                        </script>
                    @endif


                </div>
            </div><!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <table id="StudentTable" class="table table-hover table-condensed table-responsive table-bordered compact" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Student No.</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Birthday</th>
                            <th class="th-fit">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($students as $student)
                            <tr class="record-details" data-href="/students/{{ $student->Student_Id }}">
                                <td>{{$count++}}</td>
                                <td>{{$student->StudentNumber}}</td>
                                <td>{{$student->LastName}}, {{$student->FirstName}} {{$student->MiddleName}}</td>
                                <td>{{$student->Phone}}</td>
                                <td>{{$student->PersonalEmail}}</td>
                                <td>{{\Carbon\Carbon::parse($student->Birthday)->format('M d, Y')}}</td>
                                <td class="td-fit">
                                    {{ Form::open(array('url' => '/students/' . $student->Student_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                    <button type="button" class="btn btn-warning" aria-hidden="true" onclick="editStudentDetails({{ $student->Student_Id }})">
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

                    <script>
                        $(document).ready(function() {
                            $('#StudentTable').DataTable({
                                "columnDefs": [
                                    {"searchable": false, "targets": 0},
                                    {"searchable": false, "targets": 3},
                                    {"searchable": false, "targets": 4},
                                    {"searchable": false, "targets": 5},
                                    {"searchable": false, "targets": 6}
                                ],
                            });
                                    /*,{
                                     dom: 'Bfrtip',
                                     buttons: [
                                     {
                                     extend: 'copy',
                                     text: 'COPY'
                                     },
                                     {
                                     extend: 'excel',
                                     text: 'EXCEL'
                                     }
                                     , 'csv', 'pdf'
                                     ]
                                     } );
                                     }*/
                        });
                    </script>
                </div>
            </div><!-- Professor table row -->


        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for adding student">-->
        <div class="modal fade" id="addStudent" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><span class="fa fa-fw fa-child" aria-hidden="true"></span> Add Student</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('url' => '/students', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <div class="form-group">
                                <label for="StudentNumber" class="col-md-4 control-label" >Student Number</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="StudentNumber" name="StudentNumber" placeholder="ex. 2017010203" type="number" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="AcademicStatus" class="col-md-4 control-label">Academic Status</label>
                                <div class="col-lg-7" id="AcademicStatusWrapper">
                                    <select class="form-control" id="AcademicStatus" name="AcademicStatus">
                                        <option value="Regular">Regular</option>
                                        <option value="Irregular">Irregular</option>
                                    </select>
                                    <script>
                                        $('#AcademicStatus').change(function() {
                                            if(this.value == 'Regular') {
                                                $('#Section').prop('disabled', false);
                                            } else {
                                                $('#Section').prop('disabled', true);
                                            }
                                        });
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Section" class="col-md-4 control-label">Section</label>
                                <div class="col-lg-7">
                                    <select class="form-control" id="Section" name="Section">
                                        <option disabled selected value> -- select a section -- </option>
                                        @foreach($sections as $section)
                                            <option value="{{$section->Section_Id}}">{{$section->Code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="FirstName" name="FirstName" placeholder="Given Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="MiddleName" class="col-lg-4 control-label" >Middle Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="MiddleName" name="MiddleName" placeholder="Mother's Maiden Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="LastName" class="col-lg-4 control-label" >Last Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="LastName" name="LastName" placeholder="Family Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Birthday" class="col-lg-4 control-label" >Birthday</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="Birthday" name="Birthday" placeholder="ex. 2017-02-14 (yyyy-mm-dd)" type="date" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Phone" class="col-lg-4 control-label" >Contact Number</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="Phone" name="Phone" placeholder="ex. 09123457789" type="number" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="PersonalEmail" class="col-lg-4 control-label" >Email</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="PersonalEmail" name="PersonalEmail" placeholder="Personal Email" type="email" required/>
                                    <span class="help-block">Note: Used for password reset.</span>
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

        <!--<editor-fold desc="Modal for editing student">-->
        <div id="editStudentWrapper"></div>
        <!--</editor-fold>-->

        <!--<editor-fold desc="Modal for adding bulk student">-->
        <div class="modal fade" id="addBulk" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><span class="fa fa-fw fa-child" aria-hidden="true"></span> Add Student</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/getImport">
                        {!! csrf_field() !!}
                        <fieldset>
                            <div class="form-group">
                                {{--<div class="col-lg-12">--}}
                                    {{--<label for="StudentNumber" class="col-md-4 control-label" >Import File here: </label>--}}
                                    {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                                    {{--<input type="file" name="file" id="file">--}}
                                {{--</div>--}}
                                <div class="col-xs-1"></div>
                                <div class="input-group col-xs-10 text-center">
                                    <input type="file" name="file" id="file" class="file">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" class="form-control input-lg" disabled placeholder="Upload Excel / CSV file">
                                    <span class="input-group-btn">
                                    <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                    </span>
                                </div>
                                <div class="col-xs-1"></div>
                            </div>
                            <div class="form-group modal-footer">
                                <div class="col-xs-1"></div>
                                <div class="col-lg-10 text-left pull-right">
                                    <a href="/exportFile" type="button" class="btn btn-info" id="exportfile">Download Template for Bulk</a>
                                    <button type="reset" class="btn btn-info">Clear Form</button>
                                    <button type="submit" class="btn btn-success" value="Import">Save changes</button>
                                </div>
                                <div class="col-xs-1"></div>
                            </div>
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).on('click', '.browse', function(){
                var file = $(this).parent().parent().parent().find('.file');
                file.trigger('click');
            });
            $(document).on('change', '.file', function(){
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });
        </script>
        <!--</editor-fold>-->


    </div><!-- page-wrapper -->

@endsection