<?php 
include 'db_connect.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary float-right btn-sm" id="new_user_btn"><i class="fa fa-plus"></i> New user</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card col-lg-12">
            <div class="card-body">
                <table id="user_table" class="table-striped table-bordered col-md-12">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $type = array("", "Admin", "Staff", "Alumnus/Alumna");
                        $users = $conn->query("SELECT * FROM users order by name asc");
                        $i = 1;
                        while ($row = $users->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><?php echo ucwords($row['name']) ?></td>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $type[$row['type']] ?></td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#user_table').DataTable();
});

$('#new_user_btn').click(function(){
    uni_modal('New User','manage_user.php');
});

$('.edit_user').click(function(){
    uni_modal('Edit User','manage_user.php?id='+$(this).data('id'));
});

$('.delete_user').click(function(){
    _conf("Are you sure to delete this user?","delete_user",[$(this).data('id')]);
});

function delete_user($id){
    start_load();
    $.ajax({
        url:'ajax.php?action=delete_user',
        method:'POST',
        data:{id:$id},
        success:function(resp){
            if(resp==1){
                alert_toast("Data successfully deleted",'success');
                setTimeout(function(){
                    location.reload();
                },1500);
            }
        }
    });
}
</script>
