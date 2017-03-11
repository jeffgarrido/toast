@extends('studentpages.layout.studentLayout')

@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12" style="margin-top: -4ch">
                    <h1 class="page-header">
                        Manage Members<small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="glyphicon glyphicon-home"></i></li>
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </li>
                        <li class="active">
                            <i class="fa fa-users"></i> My Organization
                        </li>
                        <li class="active">
                            <i class="fa fa-connectdevelop"></i> {{$organization->Organization_Name}}
                        </li>
                        <li class="active">
                            <i class="fa fa-connectdevelop"></i> Add member
                        </li>
                    </ol>
                </div>

                <div class="col-lg-12" style="margin-top: -2ch">
                    <h3 class="page-header">Students & Members List</h3>
                    {{ Form::open(array('action' => array('OrganizationController@populateMemberList', $organization->Organization_Id), 'method' => 'post')) }}
                    <div class="form-group">
                        <select multiple="multiple" id="memberList" size="10" name="memberList[]">
                            @foreach($students as $student)
                                    <option value="{{ $student->Student_Id }}" {{ ($student->organizations()->get()->contains($organization)) ? 'selected=selected' : '' }}>{{$student->StudentNumber}}: {{$student->LastName}}, {{$student->FirstName}}</option>
                             @endforeach
                        </select>
                    </div>
                    <div class="center-block align-right">
                        <a href="/organizations/{{$organization->Organization_Id}}" class="btn btn-default align-right">Back</a>
                        <button type="submit" class="btn btn-primary align-right">Save Changes</button>
                    </div>
                    {{ Form::close() }}
                </div>

                <script>
                    $('#memberList').bootstrapDualListbox({
                        nonSelectedListLabel: 'Student/s',
                        selectedListLabel: 'Members/s',
                        preserveSelectionOnMove: false,
                        moveOnSelect: true,
                    });
                </script>
                </div>
            </div><!-- row -->


        </div><!-- container fluid -->

    </div><!-- page-wrapper -->

    <!--<editor-fold desc="Modal for editing professor">-->
    <div id="addMemberWrapper"></div>
    <!--</editor-fold>-->

@endsection

@section('organizations')
    @foreach($orgs as $org)
        <li>
            <a href="/organizations/{{$org->Organization_Id}}"><i class="fa fa-fw fa-edit"></i> {{$org->Organization_Name}}</a>
        </li>
    @endforeach
@endsection