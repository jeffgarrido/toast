@extends('admin.layout.adminLayout')

@section('body')

    <div id="page-wrapper" style="margin-top: -5ch">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Manage User
                        <button class="btn btn-lg btn-success pull-right" data-toggle="modal" data-target="#addAdminUser">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Add Admin Account
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
                            <i class="fa fa-male"></i> Accounts
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
                    <table id="UserTable" class="table table-stripe table-condensed table-responsive table-bordered compact" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Access Level</th>
                            <th class="th-fit">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1;?>
                        @foreach($users as $user)
                            <tr>
                                <td class="hidden">{{$user->id}}</td>
                                <td><?php echo $count; $count++;?></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->Access_Level}}</td>
                                <td class="td-fit">
                                    {{ Form::open(array('url' => '/users/' . $user->id, 'method' => 'DELETE', 'class' => 'form-delete', 'onsubmit' => 'return confirm("Confirm delete record? All related records will also be deleted.")')) }}
                                    <button type="button" class="btn btn-warning" aria-hidden="true" onclick="editUserDetails({{ $user->id }})">
                                        <span class="fa fa-pencil" aria-hidden="true"></span> Edit
                                    </button>
                                    <button type="button" class="btn btn-success" aria-hidden="true" onclick="resetUserPassword({{ $user->id }})">
                                        <span class="fa fa-refresh" aria-hidden="true"></span> Reset Password
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
                            $('#UserTable').DataTable( {
                                "columnDefs": [
                                    { "width": "33%", "targets": 5 }
                                ]
                            } );
                        } );
                    </script>
                </div>


            </div><!-- Professor table row -->

        </div><!-- container fluid -->

        <!--<editor-fold desc="Modal for adding professor">-->
        <div class="modal fade" id="addAdminUser" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Add New Admin</h4>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('url' => '/users', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                        <fieldset>
                            <div class="form-group">
                                <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="FirstName" name="FirstName" placeholder="Given Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="MiddleName" class="col-md-4 control-label" >Middle Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="MiddleName" name="MiddleName" placeholder="Middle Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="LastName" class="col-md-4 control-label" >Last Name</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="LastName" name="LastName" placeholder="Last Name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Access_Level" class="col-md-4 control-label" >Access Level</label>
                                <div class="col-lg-7">
                                    <input class="form-control input-md" id="Access_Level" name="Access_Level" value="Admin" type="email" readonly required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label" >Email</label>
                                <div class="col-lg-7  input-group">
                                    <input class="form-control input-md" id="email" name="email" placeholder="Email" type="email" required/>
                                    <span class="input-group-addon" id="basic-addon1">@</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label" >Password</label>
                                <div class="col-lg-7 input-group">
                                    <input type="password" class="form-control input-md" id="password" name="password" value="admin" readonly required/>
                                    <span class="input-group-addon">
                                        <input type="checkbox" id="showpass" onchange="checker(this)">
                                    </span>
                                    <script>
                                        function checker(checkbox) {
                                            if (checkbox.checked){
                                                document.getElementById('password').setAttribute('type', 'text');
                                            }
                                            else{
                                                document.getElementById('password').setAttribute('type', 'password');
                                            }
                                        }
                                    </script>
                                </div>
                                <span class="help-block" style="margin-left: 25ch">Note: Default password is 'admin'</span>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2 text-right" style="padding-right: 6ch;">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                    <button type="reset" class="btn btn-info">Clear Form</button>
                                    <button type="submit" class="btn btn-primary">Save New User</button>
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
        <div id="editUserWrapper"></div>
        <!--</editor-fold>-->


    </div><!-- page-wrapper -->

@endsection