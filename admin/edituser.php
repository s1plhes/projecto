<?php
include("../page.php");
template_header("ADMIN CENTRE",null);
admin_nav();

/* prevent XSS. */
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

$user_id = $_GET['id'];
if(isset($_POST['btn-save']))
{
    $username = trim($_POST['editusername']);
    $password = md5(trim($_POST['editpassword']));
    $email  = trim($_POST['editemail']);
    $data = ['username' => $username,'password' => $password,'email' => $email];
    $where = ['id' => $user_id];
    engine->update('accounts', $data, $where);
    header("location: index.php");
}

$user = engine->run("SELECT * FROM accounts WHERE id = ?", [$user_id])->fetch(PDO::FETCH_ASSOC);
$username = $user['username'];
$email = $user['email'];
$password = $user['password'];
$acclvl = level($user['account_level']);

echo <<<body
    <div class="d-flex justify-content-center my-2">
        <div class="profile-card">
            <div class="reply-header text-light">Edit USER</div>
                <form method="POST" action="">
                    <div class="card-header">
                        <label for="editusername" class="form-label">User name</label>
                        <input id="editusername" name="editusername" class="form-control" value="$username" placeholder="$username" aria-label="username">
                        <label>Actual: $username</label>
                    </div>
                    <div class="card-header">
                        <label for="editemail" class="form-label">User E-Mail</label>
                        <input id="editemail" name="editemail" class="form-control" value="$email" placeholder="$email" aria-label="username">
                        <label>Actual: $email</label>
                    </div>
                    <div class="card-header">
                        <label for="editpassword" class="form-label">User Password</label>
                        <input type="password" id="editpassword" name="editpassword" class="form-control" value="" placeholder="password" aria-label="username">
                    </div>
                    <div class="card-header">
                        <button id="btn-save" name="btn-save" class="btn btn-success">SAVE THIS CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
body;

?>
<style>
body{
  background-color: #271b37;  
}</style>
<?=template_footer()?>