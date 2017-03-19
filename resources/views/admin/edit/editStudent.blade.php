<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Edit Student</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/students/' . $student->Student_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="StudentNumber" class="col-md-4 control-label" >Student Number</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="StudentNumber" name="StudentNumber" value="{{$student->StudentNumber}}" placeholder="ex. 2017010203" type="number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="AcademicStatus" class="col-md-4 control-label" >Academic Status</label>
                        <div class="col-lg-7" id="AcademicStatusWrapper">
                            <select class="numbers form-control" id="AcademicStatus" name="AcademicStatus">
                                <option id="Regular" value="Regular" {{ (strcasecmp($student->AcademicStatus, 'Regular') == 0) ? 'selected="selected"': '' }}>Regular</option>
                                <option id="Irregular" value="Irregular" {{ (strcasecmp($student->AcademicStatus, 'Irregular') == 0) ? 'selected="selected"': '' }}>Irregular</option>
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
                                @foreach($sections as $section)
                                    <option value="{{$section->Section_Id}}">{{$section->Code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="FirstName" name="FirstName" value="{{$student->FirstName}}" placeholder="Given Name" type="text" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MiddleName" class="col-lg-4 control-label" >Middle Name</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="MiddleName" name="MiddleName" value="{{$student->MiddleName}}" placeholder="Mother's Maiden Name" type="text" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="LastName" class="col-lg-4 control-label" >Last Name</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="LastName" name="LastName" value="{{$student->LastName}}" placeholder="Family Name" type="text" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Birthday" class="col-lg-4 control-label" >Birthday</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Birthday" name="Birthday" value="{{$student->Birthday}}" placeholder="ex. 2017-02-14 (yyyy-mm-dd)" type="date" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Phone" class="col-lg-4 control-label" >Contact Number</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Phone" name="Phone" value="{{$student->Phone}}" placeholder="ex. 09123457789" type="number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Email" class="col-lg-4 control-label" >Email</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Email" name="Email" value="{{$student->PersonalEmail}}" placeholder="Personal Email" type="email" required/>
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