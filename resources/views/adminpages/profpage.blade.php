@extends('layouts.master')
@section('body')
    <script>
        $(document).ready(function() {
            $('#ProfTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add New Professor    ',
                        action: function ( e, dt, node, config ) {
                            $("#addProfessor").modal();
                            //alert( 'Button activated' );
                        }
                    }
                ]
            } );
        } );
    </script>
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div>
            <table id="ProfTable" class="table table-stripe table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
                <thead>
                <tr>
                    {{--<th class="hide-column">Id</th>--}}
                    <th>Id</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Birthday</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($professors as $professor)
                    <tr>
                        {{--<td class="hide-column">{{$professor->ProfessorId}}</td>--}}
                        <td>{{$professor->Professor_Id}}</td>
                        <td>{{$professor->LastName}}, {{$professor->FirstName}} {{$professor->MiddleName}}</td>
                        <td>{{$professor->Phone}}</td>
                        <td>{{$professor->Email}}</td>
                        <td>{{\Carbon\Carbon::parse($professor->Birthday)->format('M d, Y')}}</td>
                        <td>
                            <a href="#" id="edit" class=" btn btn-warning" role="button"">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                            </a>
                            <button type="button" class="btn btn-danger">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-1"></div>

    <!--<editor-fold desc="Modal for adding student">-->
    <div class="modal" id="addProfessor" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add Professor</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('action' => 'AdminController@addProfessor', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                    <fieldset>
                        <div class="form-group">
                            <label for="FirstName" class="col-md-4 control-label" >First Name</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="FirstName" name="FirstName" placeholder="FirstName" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="MiddleName" class="col-lg-4 control-label" >Middle Name</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="MiddleName" name="MiddleName" placeholder="MiddleName" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="LastName" class="col-lg-4 control-label" >Last Name</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="LastName" name="LastName" placeholder="LastName" type="text" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Birthday" class="col-lg-4 control-label" >Birthday</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Birthday" name="Birthday" placeholder="Birthday" type="date" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Phone" class="col-lg-4 control-label" >Contact Number</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Phone" name="Phone" placeholder="Phone" type="number" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Email" class="col-lg-4 control-label" >Email</label>
                            <div class="col-lg-6">
                                <input class="form-control input-md" id="Email" name="Email" placeholder="Email" type="email" required/>
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
    <!--</editor-fold>-->
@endsection