<!--<editor-fold desc="Modal for adding professor">-->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><span class="fa fa-fw fa-male" aria-hidden="true"></span> Reset Password</h3>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/users/' . $user->id.'/reset', 'method' => 'POST', 'class' => 'form-horizontal')) }}
                <fieldset>
                    <tr>
                        <td>
                            <h4 class="purple-text">
                                Are you sure to reset password for {{$user->name}}?
                            </h4>
                            <div class="pull-right">
                            <button type="submit" class="btn btn-lg btn-success">Yes</button>
                            <button type="button" data-dismiss="modal" class="btn btn-lg btn-danger" >No</button>
                            </div>
                        </td>
                    </tr>


                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<!--</editor-fold>-->