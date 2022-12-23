
<?php
include("../page.php");

if(!isset($_SESSION['loggedin'])){
    $host  = $_SERVER['HTTP_HOST'];
    header ("location: http://$host");
    exit;
} else {
    $session = $_SESSION['id'];
    if($session > 1){
        $host  = $_SERVER['HTTP_HOST'];
        header ("location: http://$host");
        exit;
    }
}
if(isset($_POST['btn-del-user'])){
  $del_id = $_POST['del-user-id'];
  $db->deleteById('accounts', $del_id);
  header("location: users.php");
}
template_header("Users Management", null);
admin_nav();
?>
<style>
body{
  background-color: #271b37;  
}</style>
<div class="row">
    <div class="col">
      <div class="table-responsive">
    <table class="table table-responsive table-sm table-dark table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">ID#</th>
          <th scope="col">User Name</th>
          <th scope="col">E-Mail</th>
          <th scope="col">Join date</th>
          <th scope="col">Status Count</th>
          <th scope="col" >Acc Level</th>
          <th scope="col" >Edit</th>
          <th scope="col" >Upgrade</th>
          <th scope="col" >Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = engine->run("SELECT * FROM accounts");
        while($result = $sql->fetch(PDO::FETCH_ASSOC)){
          $id = $result['id'];
          $username = $result['username'];
          $email = $result['email'];
          $createddate = $result['created_date'];
          $level = $result['account_level'];
          $status = get_user_status($id);
          $delete = '<button   type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del-user">delete</button>';
          $edit = "<a href='edituser.php?id=$id'><button type='button' class='btn btn-success'>Edit</button></a>";
          $upgrade = "<button class='btn btn-warning'>upgrade</button>";
          echo<<<acc

          <form method="POST" action="">
        <tr>
          <th scope="row">$id</th>
          <td>$username</td>
          <td>$email</td>
          <td>$createddate</td>
          <td>$status</td>
          <td>$level</td>
          <td>$edit</td>
          <td>$upgrade</td>
          <td>$delete</td>
        </tr>
    
        <div class="modal fade" id="del-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="del-userLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="del-userLabel">Delete User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are yout sure you want to Delete this user?.</p>
            </div>
            <div class="modal-footer">
             
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">NO!Close</button>
              <button id="btn-del-user" name="btn-del-user" class="btn btn-danger">Delete user</button>
              <input type="hidden" id="del-user-id" name="del-user-id" value="$id" placeholder="$id">
            
            </div>
          </div>
        </div>
      </div>
      <form>
acc;
}?>
</tbody>
    </table>
      </div>
      </div>
    </div>
</div>


