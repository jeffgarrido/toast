<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit {{$event->Event_Name}}</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/events/' . $event->Event_Id, 'method' => 'POST', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <div class="form-group">
                        <label for="Event_Name" class="col-md-4 control-label" >Event Name</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Event_Name" name="Event_Name" value="{{$event->Event_Name}}" placeholder="IICS General Assembly" type="text" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Description" class="col-md-4 control-label" >Description</label>
                        <div class="col-lg-7">
                            <textarea class="input" cols="42" rows="4" placeholder="Short Description" name="Description" >{{$event->Description}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Event_Date" class="col-md-4 control-label" >Event Date</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Event_Date" name="Event_Date" value="{{$event->Event_Date}}" placeholder="ex. 2017-03-30" type="date" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Start_Time" class="col-md-4 control-label" >Event Time</label>
                        <div class="col-lg-3">
                            <input class="form-control input-md col-sm-3" id="Start_Time" name="Start_Time" value="{{$event->Start_Time}}" placeholder="ex. 2017-03-30" type="time" required/>
                        </div>
                        <div class="col-lg-1">to</div>
                        <div class="col-lg-3">
                            <input class="form-control input-md col-sm-3" id="End_Time" name="End_Time" value="{{$event->End_Time}}" placeholder="ex. 2017-03-30" type="time" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Venue" class="col-md-4 control-label" >Venue</label>
                        <div class="col-lg-7">
                            <input class="form-control input-md" id="Venue" name="Venue" value="{{$event->Venue}}" placeholder="Medicine Auditorium" type="text" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Event</button>
                        <a href="/events/delete/{{$event->Event_Id}}" type="button" class="btn btn-danger pull-left">Delete Event</a>
                    </div>
                </fieldset>
                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>