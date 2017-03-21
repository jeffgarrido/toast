@extends('admin.layout.adminLayout')
@section('body')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!--<editor-fold desc="Page Header">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <b class="fa fa-lg fa-compass"></b> Manage Student Outcomes
                        <button type="button" class="btn btn-lg btn-success pull-right" data-toggle="modal" data-target="#addOutcome">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Student Outcome
                        </button>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="/">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-compass"></i> Student Outcomes
                        </li>
                    </ol>
                </div>
            </div>
            <!--</editor-fold>-->

            @foreach($studentOutcomes->chunk(4) as $outcomeChunk)
                <div class="row">
                    <div class="custom-flexbox">
                    @foreach($outcomeChunk as $outcome)
                        <div class="col-lg-3 flex-content" >
                            <div class="panel panel-default" style="min-height: 348px">
                                <div class="panel-heading flex-stretch">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="huge">{{ $outcome->Outcome_Code }}</div>
                                        </div>
                                        <div class="col-xs-9">
                                            <small>{{ $outcome->Description }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <hr/>
                                        {{ Form::open(array('url' => '/outcomes/' . $outcome->Outcome_Id, 'method' => 'DELETE', 'class' => 'form-delete')) }}
                                        <button type="button" class="btn btn-sm btn-warning btn-block" data-toggle="modal" data-target="#editOutcome{{ $outcome->Outcome_Id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete btn-block" style="bottom: 0;">
                                            <i class="fa fa-remove"></i> Delete
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--<editor-fold desc="Modal for editing outcome">-->
                        <div class="modal fade" id="editOutcome{{ $outcome->Outcome_Id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><span class="fa fa-fw fa-compass" aria-hidden="true"></span> Edit Outcome</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ Form::open(array('url' => '/outcomes/' . $outcome->Outcome_Id, 'method' => 'PATCH', 'class' => 'form-horizontal')) }}
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="Outcome_Code" class="col-md-4 control-label" >Outcome Code</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control input-md" id="Outcome_Code" name="Outcome_Code" value="{{ $outcome->Outcome_Code }}" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="Events_Minimum" class="col-md-4 control-label" >Minimum Events</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control input-md" id="Events_Minimum" name="Events_Minimum" type="number" min="0" value="{{ $outcome->Events_Minimum }}" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="Description" class="col-lg-4 control-label" >Description</label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control" rows="3" id="Description" name="Description">{{ $outcome->Description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="P1Description" class="col-lg-4 control-label" >P1 Description</label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control" rows="3" id="P1Description" name="P1Description">{{ $outcome->performanceIndicators[0]->Description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="P2Description" class="col-lg-4 control-label" >P2 Description</label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control" rows="3" id="P2Description" name="P2Description">{{ $outcome->performanceIndicators[1]->Description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="P3Description" class="col-lg-4 control-label" >P3 Description</label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control" rows="3" id="P3Description" name="P3Description">{{ $outcome->performanceIndicators[2]->Description }}</textarea>
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
                    @endforeach
                </div>
                </div>
            @endforeach

            <!--<editor-fold desc="Modal for adding outcome">-->
            <div class="modal fade" id="addOutcome" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><span class="fa fa-fw fa-compass" aria-hidden="true"></span> Add Outcome</h4>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(array('url' => '/outcomes', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                            <fieldset>
                                <div class="form-group">
                                    <label for="Outcome_Code" class="col-md-4 control-label" >Outcome Code</label>
                                    <div class="col-lg-7">
                                        <input class="form-control input-md" id="Outcome_Code" name="Outcome_Code" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="Events_Minimum" class="col-md-4 control-label" >Minimum Events</label>
                                    <div class="col-lg-7">
                                        <input class="form-control input-md" id="Events_Minimum" name="Events_Minimum" type="number" min="0" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="Description" class="col-lg-4 control-label" >Description</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" rows="3" id="Description" name="Description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="P1Description" class="col-lg-4 control-label">P1 Description</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" rows="3" id="P1Description" name="P1Description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="P2Description" class="col-lg-4 control-label">P2 Description</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" rows="3" id="P2Description" name="P2Description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="P3Description" class="col-lg-4 control-label">P3 Description</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" rows="3" id="P3Description" name="P3Description"></textarea>
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

        </div>

    </div>

@endsection