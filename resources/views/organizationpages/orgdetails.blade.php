{{--Header--}}
<div class="row">
    <div class="col-lg-8">
        <h4>{{ $organization->Organization_Name }}</h4>
        @if($organization->Description)
            <h7>{{ $organization->Description }}</h7>
        @endif
    </div>
    <div class="col-lg-4" style="text-align: right">
        <button type="button" class="btn btn-default" >Edit&nbsp;<span class="glyphicon glyphicon-pencil"></span></button>
        <button type="button" class="btn btn-danger">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
    </div>
</div>
{{--/Header--}}

<hr/>
<div>
    <ul class="nav nav-pills">
        <li><a href="#">Members</a></li>
        <li><a href="#">Events</a></li>
        </li>
    </ul>
</div>
