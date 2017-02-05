@extends('layouts.master')
@section('body')

@include('includes.loader')

<script>
    $(document).ready(function(){
        $('#navOrganization').addClass("active");
    });
</script>

{{--Org List--}}
<div class=" flexbox">
    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search Course" />
                <span class="input-group-btn">
            <button class="btn btn-default" type="button">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
            </span>
            </div>
        </div>
        <ul class="nav nav-pills nav-stacked">
            @foreach($organization as $org)
                <li class="getOrgDetails" data="{{$org->Organization_Id}}"><a href="#">{{ $org->Organization_Name }}</a></li>
            @endforeach
                <script>
                    $('.getOrgDetails').click(function () {
                        getOrganizationDetails(this.getAttribute('data'));
                    });
                </script>
            {{--<li>--}}
                {{--<a href="#" class="addOrg" data-toggle="modal" data-target="#addOrg">--}}
                    {{--<span class="glyphicon glyphicon-plus">&nbsp;</span>Add Organization--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>
    </div>

    <div id="OrgDetails" class="col-lg-9"></div>
</div>

{{--Organization Modal --}}
<div class="modal" id="addOrg" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                {{ Form::open(array('action' => 'OrganizationController@addOrg', 'method' => 'POST', 'class' => 'form-horizontal')) }}
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
<script>
    $('.btnAttendance').click(function () {

    });
    //        $('#loadingDiv').show();
    //        getAttendanceList(this.getAttribute('data'));
</script>

<script>
    $(document).ready(function(){
        $('#attendanceTable').dataTable( );
    });
</script>
@endsection