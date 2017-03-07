<div class="modal fade" id="editProfessor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Edit Professor</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('action' => 'AdminController@addProfessor', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="FirstName" name="FirstName" placeholder="Given Name" type="text" value="{{ $professor->FirstName }}" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MiddleName" class="col-lg-4 control-label" >Middle Name</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="MiddleName" name="MiddleName" placeholder="Mother's Maiden Name" type="text" value="{{ $professor->MiddleName }}" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="LastName" class="col-lg-4 control-label" >Last Name</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="LastName" name="LastName" placeholder="Family Name" type="text" value="{{ $professor->LastName }}" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Birthday" class="col-lg-4 control-label" >Birthday</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="Birthday" name="Birthday" placeholder="ex. 2017/12/25" type="date" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Phone" class="col-lg-4 control-label" >Contact Number</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="Phone" name="Phone" placeholder="ex. 09123456789" type="number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Email" class="col-lg-4 control-label" >Email</label>
                        <div class="col-lg-6">
                            <input class="form-control input-md" id="Email" name="Email" placeholder="Personal Email" type="email" required/>
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