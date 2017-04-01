<!--<editor-fold desc="Modal for adding professor">-->
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Manage Staff Members</h3>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/organizations_admin/'. $org->Organization_Id.'/staff', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="President" class="col-md-4 control-label">President</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="President" name="President">
                                @if($president)
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}" {{ (strcasecmp($student, $president) == 0) ? 'selected="selected"': '' }}>{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @elseif(!$president)
                                    <option disabled selected value> -- select a section -- </option>
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}">{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Vice_President" class="col-md-4 control-label">Vice President</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="Vice_President" name="Vice_President">
                                @if($vp)
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}" {{ (strcasecmp($student, $vp) == 0) ? 'selected="selected"': '' }}>{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @elseif(!$vp)
                                    <option disabled selected value> -- select a section -- </option>
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}">{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Treasurer" class="col-md-4 control-label">Treasurer</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="Treasurer" name="Treasurer">
                                @if($tres)
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}" {{ (strcasecmp($student, $tres) == 0) ? 'selected="selected"': '' }}>{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @elseif(!$tres)
                                    <option disabled selected value> -- select a section -- </option>
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}">{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Secretary" class="col-md-4 control-label">Secretary</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="Secretary" name="Secretary">

                                @if($sec)
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}" {{ (strcasecmp($student, $sec) == 0) ? 'selected="selected"': '' }}>{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @elseif(!$sec)
                                    <option disabled selected value> -- select a section -- </option>
                                    @foreach($students as $student)
                                        <option value="{{$student->Student_Id}}">{{$student->LastName}}, {{$student->FirstName}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Adviser" class="col-md-4 control-label">Organization Adviser</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="Adviser" name="Adviser">
                                <option disabled selected value> -- select a section -- </option>
                                @foreach($profs as $prof)
                                    <option value="{{$prof->Professor_Id}}" {{ (strcasecmp($prof, $org->professors) == 0) ? 'selected="selected"': '' }}>{{$prof->LastName}}, {{$prof->FirstName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group modal-footer">
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