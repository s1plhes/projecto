<?php
include "../page.php";
template_header("status");
$sid = $_GET['sid'];
$sql = engine->run("SELECT * FROM user_status WHERE id = ? LIMIT 1",[$sid]);
while($status_data = $sql->fetch(PDO::FETCH_ASSOC)){    
    $user_id = $status_data['user_id'];
    $status = $status_data["status_text"];
    $publisheddate = $status_data["published_date"];
    $tm = time_elapsed_string($publisheddate);
    $timetest = $_SERVER['REQUEST_TIME'];
    $status_id = $status_data['id'];
    $status_query_data_b = engine->run("SELECT * FROM accounts WHERE id = ? ORDER BY id DESC",[$user_id]);
    $status_data_b = $status_query_data_b->fetch(PDO::FETCH_ASSOC);
    $name = profileName($status_data_b['username']);
    $link_name  = profileLink($status_data_b['username']);
    $gravatar = get_gravatar("$name");
    $replieschecker = replied_check($sid);


        echo<<<EOT
        <div class="profile-bg">
        <div class="d-flex justify-content-center">
            <div class="profile-card placeholder-glow my-2" style="width: 35rem;">
                <div class="reply-header skeleton"> <h3 class="placeholder">
                <img src="$gravatar" alt="" style="width:40px;" class="rounded-pill">$link_name| $tm</h3>
                </div>
                $replieschecker
                <div class="status-body placeholder-glow">
                    <h2 class="placeholder">$status.</h2>

EOT;
                if (isset(($_SESSION['loggedin']))) {
                    echo <<<reply
                <script>
                function showrc$status_id$name$user_id(){
                document.getElementById('$status_id$name$user_id').style.display = 'grid';
                }
                </script>

                <a type="button" class="placeholder" id="replybtn" onClick="showrc$status_id$name$user_id()">
                <button class="btn vhmbtn placeholder">Reply $name</button>
                </a>
                <form method="post" action="../profile/post_reply.php" id="$status_id$name$user_id" style="display:none">
                    <textarea class="form-control" placeholder="Write your reply" id="reply_text" 
                    name="reply_text" minlength="4" maxlength="280"></textarea>
                    <button class="vhmbtn btn" type="submit" id="publish">Reply</button>
                    <input id="parent_id" name="parent_id" value="$sid" class="invisible"></input>
                </form>                      
reply;
}
echo<<<EOT

</div>
<div class="reply-footer skeleton">
EOT;
            $st = engine->run("SELECT * FROM user_status WHERE parent_id = ?ORDER BY id DESC",[$status_id]);
            if ($st->rowCount() > 0)
            {           
                while($rs = mysqli_fetch_assoc($st))
                {      
                    $reply_date = $rs["published_date"];
                    $reply_time = time_elapsed_string($reply_date);
                    $reply_status = $rs["status_text"];
                    $reply_id_id = $rs["id"];
                    $i = $rs["user_id"];
                    $reply_parent = $rs["parent_id"];
                    $reply_userlink = profileLink($i);

                    $getting_reply_user_data = engine->run("SELECT * FROM accounts WHERE id = ?",[$i]);
                    $reply_user_data = $getting_reply_user_data->fetch(PDO::FETCH_ASSOC);
                    $reply_username = $reply_user_data['username'];
                    $gravatar = get_gravatar($reply_username);
                    echo<<<replies
                        <div class="placeholder-glow">                 
                        <p class="reply-box placeholder">—<img src="'. $gravatar .'" alt="" style="width:40px;" class="rounded-pill"> 
                        $reply_status | <i>$reply_userlink | <a class="placeholder" href="status.php?sid=$reply_id_id">$reply_time</a></i>   
                                      
replies;
                        if (isset(($_SESSION['loggedin']))) {
                            echo<<<repliesform
                            <script> function showrc$reply_id_id$reply_username$reply_id_id$reply_parent(){
                            document.getElementById('$reply_id_id$reply_username$reply_id_id$reply_parent').style.display = 'grid'; }
                            </script>

                            <a type="button" id="replybtn" onClick="showrc$reply_id_id$reply_username$reply_id_id$reply_parent()">
                            <button class="btn vhmbtn">Reply</button></a>

                            <form method="post" action="../profile/post_reply.php" id="$reply_id_id$reply_username$reply_id_id$reply_parent" style="display:none">
                                <textarea class="form-control" placeholder="Write your reply" id="reply_text" 
                                name="reply_text" minlength="4" maxlength="280"></textarea>
                                <button class="vhmbtn btn" type="submit" id="publish">Reply</button>
                                <input id="parent_id" name="parent_id" value="$sid" class="invisible"></input>
                            </form>   </div>                    
                                                                                            
repliesform;
                        }
                }
            } else {echo 'no replies';}

echo "</div></div></div>

";
} 



echo "";
template_footer();
?>