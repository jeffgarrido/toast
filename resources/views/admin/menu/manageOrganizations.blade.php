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
            @if($errors->any())
                <div class="alert alert-success alert-dismissable fade in" id="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{$errors->first()}}</strong>
                </div>
                <script>
                    $("#alert").fadeTo(5000, 500).slideUp(500, function(){
                        $("#alert").slideUp(500);
                    });
                </script>
            @endif

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
                                    {{ Form::open(array('url' => '/organizations_admin/' . $organization->Organization_Id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                                    <button type="button" class="btn btn-warning editorg" aria-hidden="true" data-name="{{$organization->Organization_Name}}" data-desc="{{$organization->Description}}" data-id="{{$organization->Organization_Id}}" data-prof="{{$organization->Adviser_Id}}" data-toggle="modal" data-target="#editOrg">
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
                </div>
            </div><!-- Professor table row -->


        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for editing organization">-->
        <div class="modal" id="editOrg" tabindex="1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="Title_Header">Edit Organization <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h3>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('url' => '/organizations_admin', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <input id="Organization_Id" name="Organization_Id" type="hidden">
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
                                    <select class="form-control" id="Adviser_Id" name="Adviser_Id">
                                        <option disabled selected value> -- select a section -- </option>
                                        @foreach($profs as $prof)
                                            <option value="{{$prof->Professor_Id}}">{{$prof->FirstName}} {{$prof->LastName}}</option>
                                        @endforeach
                                    </select>
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

        <!--<editor-fold desc="Modal for adding organization">-->
        <div class="modal" id="addOrg" tabindex="1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add new organization</h3>
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
                                    <select class="form-control" id="Adviser_Id" name="Adviser_Id" required>
                                        <option disabled selected value> -- select a section -- </option>
                                        @foreach($profs as $prof)
                                            <option value="{{$prof->Professor_Id}}">{{$prof->FirstName}} {{$prof->LastName}}</option>
                                        @endforeach
                                    </select>
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
    <script>
        $(document).on("click",".editorg",function(){
            var orgId = $(this).data('id');
            var orgName = $(this).data('name');
            var orgDesc = $(this).data('desc');
            var orgProf = $(this).data('prof');
            $(".modal-body #Description").val( orgDesc );
            $(".modal-body #Organization_Name").val( orgName );
            $(".modal-body #Organization_Id").val( orgId );
            $(".modal-header #Title_Header").text( "Edit Organization - "+orgName );
        });
        $(document).ready(function() {
            $('#orgTable').DataTable();
        } );
    </script>
@endsection