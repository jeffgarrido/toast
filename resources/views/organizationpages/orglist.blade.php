@extends('layouts.master')
@section('body')

<script>
    $(document).ready(function(){
        $('#navOrganization').addClass("active");
    });
</script>

    {{--Org List--}}
    <div class=" flexbox">
        <div class="col-lg-3 border-right" style="border-right: solid">
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
                    <li class="test" data="{{$org->Organization_Id}}"><a href="#">{{ $org->Organization_Name }}</a></li>
                @endforeach
                    <script>
                        $('.test').click(function () {
                            getOrganizationDetails(this.getAttribute('data'));
                        });
                    </script>
                <li>
                    <a href="#" class="addCourse" data-toggle="modal" data-target="#addCourse">
                        <span class="glyphicon glyphicon-plus">&nbsp;</span>Add Course
                    </a>
                </li>
            </ul>
        </div>

        <div id="OrgDetails" class="col-lg-9"></div>
    </div>
    {{--/Org List--}}

{{--Ajax Scripts--}}
<script src="js/ajax.js"></script>
{{--customjs Scripts--}}
<script src="js/customjs.js"></script>

@endsection