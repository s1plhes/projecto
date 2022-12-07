<?php
//index.php by Siplhes
include "../page.php";
$userid = $_GET["userid"]; //getting the User Id
$sql = mysqli_query(conn,"SELECT * FROM accounts WHERE id=$userid");
$profile = mysqli_fetch_assoc($sql);
$profileUsername = $profile['username'];
$gravatar = user_avatar($profile['id']);
$followbtn = isFollowing($userid);
$articles = gettingWrittenBlogE($profile['username']);
$followersnum = gettingFollowers($userid);
$followingnum = gettingFollowing($userid);


//placing the header
template_header($profileUsername);
echo 
<<<EOT
    <link href="../profile/profile.css" rel="stylesheet">
        <!-- Column -->
            <div class="card-body little-profile text-center">
                <div class="pro-img"><img src="$gravatar" alt="user"></div>
                <h3 class="m-b-0">$profileUsername</h3>
                $followbtn
                <div class="row text-center m-t-3">
                    <div class="col-lg-4 col-md-4 m-t-3">
                        <h3 class="m-b-0 font-light">$articles</h3><small>Articles</small>
                    </div>
                    <div class="col-lg-4 col-md-4 m-t-3">
                        <div type="button" data-bs-toggle="modal" data-bs-target="#followers">
                            <h3 class="m-b-0 font-light">$followersnum</h3><small>Followers</small>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 m-t-3">
                    <div type="button" data-bs-toggle="modal" data-bs-target="#followings">
                        <h3 class="m-b-0 font-light">$followingnum</h3><small>Following</small>
                        </div>
                    </div>
                </div>
                <hr>
            </div> 

            <div class="modal fade" id="followers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">$profileUsername followers</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
EOT;


    $fllw_q = mysqli_query(conn,"SELECT the_follower FROM followers WHERE the_followed=\"$profileUsername\" ORDER BY id;");
    while($rq = mysqli_fetch_assoc($fllw_q)){
        $follower = profileLink($rq["the_follower"]);
        echo 
<<<EOT
        <div class="row">
        <div class="col">
        <p class="btn" style="color:black !important">$follower</p>
        </div>
        <div class="col">
        <button class="btn vhmbtn">Follow</button>
        </div>
        </div>


 EOT;
        
           }
echo
<<<EOT
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">$profileUsername follows</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
EOT;


$fllw_q = mysqli_query(conn,"SELECT the_followed FROM followers WHERE the_follower=\"$profileUsername\" ORDER BY id;");
while($rq = mysqli_fetch_assoc($fllw_q)){
    $follower = profileLink($rq["the_followed"]);
    echo 
<<<EOT
    <div class="row">
        <div class="col">
            <p class="btn" style="color:black !important">$follower</p>
        </div>
        <div class="col">
        <button class="btn vhmbtn">Follow</button>
        </div>
    </div>


EOT;
       }
echo
<<<EOT
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
EOT;
if(isset($_SESSION["loggedin"])){
    if($_SESSION["id"] == $userid){
        echo
<<<EOT
    <div class="bg-light">
    <div class="row text-center d-flex justify-content-center py-3">
        <div class="col d-flex justify-content-center">
            <form method="post" action="../profile/post_status.php" style="max-width: 300px;">
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="submit" id="publish">Publish</button>
                        <textarea class="form-control" placeholder="What's happening?" id="status" name="status" minlength="4" maxlength="280"required></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div> 

EOT;
    }
}


$fllw_q = mysqli_query(conn,"SELECT * FROM user_status WHERE user_id=\"$userid\" ORDER BY id DESC;");
while($rq = mysqli_fetch_assoc($fllw_q)){
    $status = $rq["status_text"];
    $name = profileLink($profileUsername);
    $publisheddate = $rq["published_date"];
    $tm = time_elapsed_string($publisheddate);
    $timetest = $_SERVER['REQUEST_TIME'];
    echo 
<<<EOT
        <div class="d-flex justify-content-center my-2">
            <div class="card my-2" style="width: 35rem;" >
                <div class="card-header"> 
                    @$name 
                </div>
                <div class="card-body">
                    <p class="card-text">$status.</p>
                </div>
                    <div class="card-footer text-muted">$tm</div>
            </div>            
        </div>
EOT;
       }


template_footer();
    ?>

