<?php
/**
 * Profile index.php
 * Coded by Siplhes
 */

include "../page.php";
$profile_username = $_GET["user"]; //getting the User Id
$sql = mysqli_query(conn,"SELECT * FROM accounts WHERE username='$profile_username'");
$profile = mysqli_fetch_assoc($sql);
$gravatar = user_avatar($profile['id']);
$followbtn = isFollowing($profile_username);
$articles = number_format(gettingWrittenBlogE($profile_username));
$followersnum = number_format(gettingFollowers($profile_username));
$followingnum = number_format(gettingFollowing($profile_username));
$user_status_count = number_format(get_user_status($profile['id']));
//placing the header
template_header($profile_username. " | Vehement",NULL);

/** *   *   *   *
 * user avatar  *
 *  *   *   *   *
 *  */ 
echo <<<EOT

<div class="card-body little-profile text-center">
    <div class="pro-img"><img src="$gravatar" alt="user"></div>
        <h3 class="m-b-0">$profile_username</h3>
        $followbtn
        <div class="row text-center m-t-3 d-flex align-items-center justify-content-center">
            <div class="col-lg-1 col-md-1 m-t-2">
                <h3 class="m-b-0 font-light">$articles</h3><small>Articles</small>
            </div>
            <div class="col-lg-1 col-md-1 m-t-2">
                <h3 class="m-b-0 font-light">$user_status_count</h3><small>Status</small>
            </div>
            <div class="col-lg-1 col-md-1 m-t-2">
                <div type="button" data-bs-toggle="modal" data-bs-target="#followers">
                    <h3 class="m-b-0 font-light">$followersnum</h3><small>Followers</small>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 m-t-2">
                <div type="button" data-bs-toggle="modal" data-bs-target="#followings">
                    <h3 class="m-b-0 font-light">$followingnum</h3><small>Following</small>
                    </div>
                </div>
            </div>  
        </div>
EOT; 
/**
 * MODALS
 *  */        
echo <<<Modal
    <div class="modal fade" id="followers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">$profile_username followers</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
Modal;
    $sql = engine->run("SELECT the_follower FROM followers WHERE the_followed = ? ORDER BY id", [$profile_username]);
    $count = $sql->rowCount();
    if ($count > 0){
        while ($result = $sql->fetch(PDO::FETCH_BOTH)){
            $a = $result[0];
            $btn = isFollowing($a);
            $name = profileLink($a);
            $avatar = user_avatar($a);
            echo <<<EOT
                <div class="row d-flex align-items-center">
                    <div class="col d-flex align-items-center">
                        <div class="follower_avatar d-flex p-2"><img src="$avatar" class="rounded-pill" width="50px" alt="user"></div>
                        <p class="btn d-flex p-2" style="color:black !important">$name</p>
                    </div>
                    <div class="col d-flex p-2">
                    $btn
                    </div>
                </div>
EOT;
        }   
    } else {        
echo <<<EOT
                <div class="row">
                    <div class="col">
                        <p class="btn" style="color:black !important">Not Found</p>
                    </div>
                </div>
EOT;
}
echo<<<EOT
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="followings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">$profile_username follows</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
EOT;

$sql = engine->run("SELECT the_followed FROM followers WHERE the_follower = ? ORDER BY id", [$profile_username]);
$count = $sql->rowCount();
if ($count > 0){
    while ($result = $sql->fetch(PDO::FETCH_BOTH)){
        $b = $result[0];
        $btn = isFollowing($b);
        $name = profileLink($b);
        $avatar = user_avatar($b);
        echo<<<EOT
                <div class="row d-flex align-items-center">
                    <div class="col d-flex align-items-center">
                        <div class="follower_avatar d-flex p-2">
                            <img src="$avatar" class="rounded-pill" width="50px" alt="user">
                        </div>
                        <p class="btn d-flex p-2" style="color:black !important">$name</p>
                    </div>
                    <div class="col">
                        $btn
                    </div>
                </div>
EOT;
    }
} else {
    echo<<<EOT
            <div class="row">
                <div class="col">
                    <p class="btn" style="color:black !important">Not Found</p>
                </div>
            </div>
    EOT;

}
echo<<<EOT
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="profile-bg">

    <div class="profil-nav d-flex justify-content-center usernavbar sticky-top">
        <ul class="nav nav-pills align-self-center">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#statuses">Statuses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#menu2">Settings</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane container active" id="statuses">
            <div class="row">
                <div class="col">

EOT;
if(isset($_SESSION["loggedin"])){
    if($_SESSION["name"] == $profile_username){
        $safe_post_status = htmlspecialchars("../profile/post_status.php");
        echo<<<STATUS
                    <div class="row text-center d-flex justify-content-center py-3">
                        <div class="col d-flex justify-content-center">
                            <form method="post" action="$safe_post_status" class="w-100" style="max-width:100%;">
                                <div class="form-group status-group">
                                    <div class="input-group">
                                        <button class="btn status-send-btn" type="submit" id="publish">Publish<span class="glyphicon glyphicon-send"></span></button>
                                        <span class="status-counter">0/200</span>
                                        <textarea class="form-control status-textarea" placeholder="What's happening?" rows="6" name="status" minlength="4" maxlength="280"required></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 
                    
STATUS;
    } }

$userid = $profile['id'];
$sql = engine->run("SELECT * FROM user_status WHERE user_id = ? ORDER BY id DESC",[$userid]);
    while($result = $sql->fetch(PDO::FETCH_BOTH)){
        $status = $result[2];
        $name = profileName($profile_username);
        $link_name = profileLink($profile_username);
        $date = $result[4];
        $tm = time_elapsed_string($date);
        $status_id = $result[0];
        $replieschecker = replied_check($status_id);
echo <<<EOT
                    <div class="d-flex justify-content-center my-2">
                        <div class="profile-card my-2 " style="width: 35rem;">
                            <div class="reply-header placeholder-glow"> 
                                <h3 class="placeholder">$link_name <a class="text-decoration-none" href="status.php?sid=$status_id">$tm</a></h3>
                            </div>
                            $replieschecker
                            <div class="status-body placeholder-glow">
                                <h2 class="placeholder">$status.</h2>
EOT;
    if (isset(($_SESSION['loggedin']))) {
    echo <<<reply
                        <script>function showrc$status_id$name$userid(){ document.getElementById('$status_id$name$userid').style.display = 'grid';}</script>
                        <a type="button" onClick="showrc$status_id$name$userid()"><button class="btn vhmbtn">Reply $name</button></a>
                        <form method="post" action="../profile/post_reply.php" id="$status_id$name$userid" style="display:none">
                        <textarea class="form-control" placeholder="Write your reply" name="reply_text" minlength="4" maxlength="280"></textarea>
                        <button class="vhmbtn btn" type="submit" >Publish</button>
                        <input name="parent_id" value="$status_id" class="invisible"></input>
                        </form>                      
reply;
    }        
                    echo<<<EOT
                    </div>
                    <div class="reply-footer">
EOT;    
                    $st = engine->run("SELECT * FROM user_status WHERE parent_id = ? ORDER BY id DESC", [$status_id]);
                    $st_row = $st->rowCount();
                    if ($st_row > 0){           
                        while($rs = $st->fetch(PDO::FETCH_ASSOC)){

                        $reply_date = $rs["published_date"];
                        $reply_time = time_elapsed_string($reply_date);
                        $reply_status = $rs["status_text"];
                        $reply_id = $rs['id'];
                        $i = $rs["user_id"];
                        $reply_id_id = $rs["id"];
                        $reply_parent = $rs["parent_id"];
                        $reply_userlink = profileLink($i);
                        $getting_reply_user_data = mysqli_query(conn,"SELECT * FROM accounts WHERE id=\"$i\"");
                        $reply_user_data=mysqli_fetch_assoc($getting_reply_user_data);
                        $reply_username = $reply_user_data['username'];
                        echo<<<replies
                    <div class="placeholder-glow">                 
                        <p class="reply-box placeholder">—<img src="'. $gravatar .'" alt="" style="width:40px;" class="rounded-pill placeholder"> 
                            $reply_status | <i>$reply_userlink | <a class="placeholder" href="status.php?sid=$reply_id_id">$reply_time</a></i></p>                        
replies;
                        if (isset(($_SESSION['loggedin']))) {
                            echo<<<repliesform
                        <script>
                         function showrc$reply_id_id$reply_username$reply_id_id$reply_parent(){document.getElementById('$reply_id_id$reply_username$reply_id_id$reply_parent').style.display = 'grid';}
                        </script>
                         <a type="button" id="replybtn" onClick="showrc$reply_id_id$reply_username$reply_id_id$reply_parent()">
                         <button class="btn vhmbtn">Reply</button></a>
                           <form method="post" action="../profile/post_reply.php" id="$reply_id_id$reply_username$reply_id_id$reply_parent" style="display:none">
                            <textarea class="form-control" placeholder="Write your reply"
                            name="reply_text" minlength="4" maxlength="280"></textarea>
                            <button class="vhmbtn btn" type="submit">Publish</button>
                            <input name="parent_id" value="$reply_id_id" class="invisible"></input>
                        </form>                                                         
repliesform;
}
                }
    
            } else {echo 'no replies';}           
echo '</div>
    </div>
</div>'; //DON'T DELETE XD

} 
    $created_date = $profile["created_date"];
    $tcd = time_elapsed_string($created_date);
echo <<<EOT
</div> </div> </div> </div> 
<div class="col"> 
    <div class="sticky-top"> <div>
    <div class="container mt-3 d-flex sticky-top mt-5">
        <div class="profile-info">
            $profile_username is a Member since $tcd who aported $articles in this community. $profile_username has 
            $followersnum members following his work and he follows $followingnum members
        </div>
    </div>
    </div>
</div> </div> </div> </div> 
EOT;

template_footer();

