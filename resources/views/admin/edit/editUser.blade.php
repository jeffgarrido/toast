<!--<editor-fold desc="Modal for adding professor">-->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Add New Admin</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/users/' . $user->id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group -align-center">
                        <label for="name" class="col-md-4 control-label" >Name</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="name" name="name" value="{{$user->name}}" placeholder="Given Name" type="text" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label" >Email</label>
                        <div class="col-lg-7  input-group">
                            <input class="form-control input-md" id="email" name="email" placeholder="Email" value="{{$user->email}}" type="email" required/>
                            <span class="input-group-addon" id="basic-addon1">@</span>
                        </div>
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