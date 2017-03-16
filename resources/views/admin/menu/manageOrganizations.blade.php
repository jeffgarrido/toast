`@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper" style="margin-top: -5ch">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Manage Oranizations<button class="btn btn-success pull-right" data-toggle="modal" data-target="#addOrg">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Add Organization
                        </button>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-child"></i> Organizations
                        </li>
                    </ol>
                </div>
            </div><!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <table id="orgTable" class="table table-stripe table-condensed table-responsive hover table-bordered compact" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Adviser</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizations as $organization)
                            <tr>
                                <td class="hidden">{{$organization->Organization_Id}}</td>
                                <td class="record-details" data-href="/organizations_admin/{{ $organization->Organization_Id }}/home">{{$loop->iteration}}</td>
                                <td class="record-details" data-href="/organizations_admin/{{ $organization->Organization_Id }}/home">{{$organization->Organization_Name}}</td>
                                <td class="record-details" data-href="/organizations_admin/{{ $organization->Organization_Id }}/home">{{$organization->Description}}</td>
                                <td class="record-details" data-href="/organizations_admin/{{ $organization->Organization_Id }}/home">{{$organization->professors->LastName}}, {{$organization->professors->FirstName}} {{$organization->professors->MiddleName}}</td>
                                <td>
                                    {{--{{ Form::open(array('url' => '/students/' . $student->Student_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}--}}
                                    <button type="button" class="btn btn-warning" aria-hidden="true">
                                        <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                    </button>
                                    <button type="submit" class="btn btn-danger" aria-hidden="true">
                                        <span class="fa fa-remove"></span> Delete
                                    </button>
                                    {{--{{ Form::close() }}--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function() {
                            $('#orgTable').DataTable();
                        } );
                    </script>
                </div>
            </div><!-- Professor table row -->


        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for adding professor">-->
        <div class="modal" id="addOrg" tabindex="1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('action' => 'AdminOrgController@addOrg', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <div class="form-group">
                                <label for="Organization_Name" class="col-lg-2 control-label" style="text-align: left">Organization Name</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Organization_Name" name="Organization_Name" placeholder="Organization Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Description" class="col-lg-2 control-label" style="text-align: left">Description</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" id="Description" name="Description" style="resize: vertical;"></textarea>
                                    <span class="help-block">Note: Description is optional</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Adviser_Id" class="col-lg-2 control-label" style="text-align: left">Adviser Name</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Adviser_Id" name="Adviser_Id" placeholder="Adviser Name" type="text" required/>
                                </div>
                            </div>
                            <hr/>
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

        <!--<editor-fold desc="Modal for editing professor">-->
        <div id="editOrgWrapper"></div>
        <!--</editor-fold>-->


    </div><!-- page-wrapper -->

@endsection