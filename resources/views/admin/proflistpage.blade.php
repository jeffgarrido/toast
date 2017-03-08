<table id="ProfTable" class="table table-stripe table-condensed table-responsive table-bordered" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th class="hide-column">Id</th>
        <th>No.</th>
        <th>Name</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Birthday</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $count = 1;?>
    @foreach($professors as $professor)
        <tr>
            <td class="hide-column">{{$professor->ProfessorId}}</td>
            <td><?php echo $count; $count++;?></td>
            <td>{{$professor->LastName}}, {{$professor->FirstName}} {{$professor->MiddleName}}</td>
            <td>{{$professor->Phone}}</td>
            <td>{{$professor->Email}}</td>
            <td>{{\Carbon\Carbon::parse($professor->Birthday)->format('M d, Y')}}</td>
            <td>
                <a href="edit_professor/{{$professor->Professor_Id}}" id="edit" class=" btn btn-warning" role="button">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteProfessor({{$professor->Professor_Id}})">Delete&nbsp;<span class="glyphicon glyphicon-remove"></span></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

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