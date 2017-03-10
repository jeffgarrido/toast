@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">


            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-book"></b> Manage Courses
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-book"></i> Manage Courses
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            <div class="row">
                <div class="col-lg-12">
                    <table id="CourseTable" class="table table-hover table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Course Code</th>
                            <th>Title</th>
                            <th>Units</th>
                            <th>Description</th>
                            <th>Terms</th>
                            <th class="th-fit">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($courses as $course)
                            <tr class="record-details" data-href="/courses/{{ $course->Course_Id }}">

                                    <td class="hidden">{{$course->Course_Id}}</td>
                                    <td>{{$count++}}</td>
                                    <td>{{$course->Code}}</td>
                                    <td>{{$course->Title}}</td>
                                    <td>{{$course->Units}}</td>
                                    <td>{{$course->Description}}</td>
                                    <td>{{$course->Terms}}</td>
                                    <td class="td-fit">
                                        {{ Form::open(array('url' => '/courses/' . $course->Course_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                                            <a href="/courses/{{ $course->Course_Id }}/edit" class="btn btn-warning" aria-hidden="true">
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

                    <script>
                        $(document).ready(function() {
                            $('#CourseTable').DataTable();
                            $('.record-details').click(function() {
                                window.location = $(this).data('href');
                            });
                        } );
                    </script>
                </div>
            </div>

            <a href="/courses/create" class="btn btn-success">
                <i class="fa fa-user-plus" aria-hidden="true"></i> Add Course
            </a>
        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for adding courses">-->
        <div class="modal fade" id="addCourse" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" id="myModalLabel"><b class="fa fa-fw fa-book"></b>Add Course</h3>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('action' => 'CourseController@addCourse', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <div class="form-group">
                                <label for="Code" class="col-lg-4 control-label">Course Code</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="Code" name="Code" placeholder="Course Code" type="text" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Title" class="col-lg-4 control-label">Title</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="Title" name="Title" placeholder="Title" type="text" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Title" class="col-lg-4 control-label">Units</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="Units" name="Units" placeholder="Units" type="number" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Terms" class="col-lg-4 control-label">Number of Terms</label>
                                <div class="col-lg-7">
                                    <select class="form-control" id="Terms" name="Terms" required>
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
                            <hr/>
                            <div class="form-group">
                                <div class="col-lg-7 col-lg-offset-4 text-right">
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

        <!--<editor-fold desc="Modal for editing courses">-->
        <div id="editCoursesWrapper"></div>
        <!--</editor-fold>-->


    </div><!-- page-wrapper -->

@endsection