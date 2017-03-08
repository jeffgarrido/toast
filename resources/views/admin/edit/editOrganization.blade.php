<div class="modal fade" id="editOrgModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Edit Organization</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/organizations/' . $organization->Organization_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="Organization_Name" class="col-lg-2 control-label" style="text-align: left">Organization Name</label>
                        <div class="col-lg-10">
                            <input class="form-control" id="Organization_Name" name="Organization_Name" value="{{$organization->Organization_Name}}" placeholder="Organization Name" type="text" required autofocus/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Description" class="col-lg-2 control-label" style="text-align: left">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="Description" name="Description" style="resize: vertical;" autofocus required>{{$organization->Description}}</textarea>
                            <span class="help-block">Note: Description is required</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Adviser_Id" class="col-lg-2 control-label" style="text-align: left">Adviser Name</label>
                        <div class="col-lg-10">
                            <input class="form-control" id="Adviser_Id" name="Adviser_Id" placeholder="Adviser Name" value="{{$organization->Adviser_Id}}" type="text" autofocus required/>
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