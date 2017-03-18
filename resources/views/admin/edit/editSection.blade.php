<div class="modal fade" id="editSectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Edit Professor</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/sections/' . $section->Section_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="Code" class="col-lg-4 control-label" >Section Code</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Code" name="Code" placeholder="Section Code" value="{{ $section->Code }}" type="text" required/>
                        </div>
                    </div>

                    <?php $year = \Carbon\Carbon::now()->year ?>

                    <div class="form-group">
                        <label for="AcademicYearStart" class="col-lg-4 control-label" >Academic Year Start</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="AcademicYearStart" name="AcademicYearStart" placeholder="{{ $year }}" value="{{ $section->AcademicYearStart }}" type="number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="AcademicYearEnd" class="col-lg-4 control-label" >Academic Year End</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="AcademicYearEnd" name="AcademicYearEnd" placeholder="{{ $year + 1 }}" value="{{ $section->AcademicYearEnd }}" type="number" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <select id="editStudentsList" multiple="multiple" name="editStudentsList[]">
                                @foreach($students as $student)
                                    <option value="{{ $student->Student_Id}}" {{ $section->students->contains($student) ? 'selected="selected"': '' }}>
                                        {{$student->LastName}}, {{$student->FirstName}} {{$student->MiddleName}}
                                    </option>
                                @endforeach
                            </select>
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