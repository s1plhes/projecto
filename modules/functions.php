<?php

session_start();

function admin_control(){

    if(isset($_SESSION['loggedin'])){

        session_regenerate_id();
        if ($result["account_level"] = 3){
        $_SESSION["isadmin"] = true;       
        $id = $_SESSION['id'];
        $sql = mysqli_query(conn,"SELECT * FROM accounts WHERE id=$id");
        $result = mysqli_fetch_assoc($sql);
        }
    }
}
function urlFetch($f)
{
    if($f)
    {
        $sql = mysqli_query(conn,'SELECT id FROM accounts WHERE username="'.$f.'"');
        $result = mysqli_fetch_assoc($sql);
        $theUserId = $result['id'];
        $host  = $_SERVER['HTTP_HOST'];
        $extra = 'profile/?userid=';
        $header = "http://$host/$extra";
        $url = '<a class="text-decoration-none"href='.$header.''.$theUserId.'>'.$f.'</a>';
        return $url;
    }
}
function profileLink($i){
    $id = $i;
    $sql = mysqli_query(conn,"SELECT * FROM accounts WHERE id=\"$id\" OR username=\"$id\";");
    $result = mysqli_fetch_assoc($sql);
    $gettuserid = $result["id"];
    $host  = $_SERVER['HTTP_HOST'];
    $extra = 'profile/?userid=';
    $header = "http://$host/$extra";
    $url = '<a class="text-decoration-none"href='.$header.''.$gettuserid.'>'.$i.'</a>';
    return $url;
}
function gettingWrittenBlogE($i)
{
    $sql = mysqli_query(conn,'SELECT COUNT(author) FROM blog WHERE author="'.$i.'"');
    $result = mysqli_fetch_assoc($sql);
    $num = implode($result);
    return $num;
}
function gettingFollowers($i){
    $user = $i;
    $sql1 = mysqli_query(conn,"SELECT * FROM accounts WHERE id=$user");
    $row = mysqli_fetch_assoc($sql1);
    $u = $row["username"];
    $sql = mysqli_query(conn,'SELECT COUNT(the_follower) FROM followers WHERE the_followed="'.$u.'"');
    $fllw = mysqli_fetch_assoc($sql);
    $fllwCount = implode($fllw);
    return $fllwCount;
}
function gettingFollowing($i){
    $user = $i;
    $sql1 = mysqli_query(conn,"SELECT * FROM accounts WHERE id=$user");
    $row = mysqli_fetch_assoc($sql1);
    $u = $row["username"];
    $sql = mysqli_query(conn,'SELECT COUNT(the_followed) FROM followers WHERE the_follower="'.$u.'"');
    $fllw = mysqli_fetch_assoc($sql);
    $fllwCount = implode($fllw);
    return $fllwCount;
}

function isFollowing($i){
    if(isset(($_SESSION["loggedin"]))){
        $sql_query = mysqli_query(conn,"SELECT * FROM accounts WHERE id=$i"); //getting UA
        $row = mysqli_fetch_assoc($sql_query); // fetching UA
        $ua = $row["username"];
        $y = $_SESSION["name"];
        $sql = mysqli_query(conn,'SELECT * FROM followers WHERE the_follower="'.$y.'"  AND the_followed="'.$ua.'"'); //SQL to compare
        $total_row= mysqli_num_rows($sql); //fetching
        if($_SESSION["name"] == $row["username"]){

            $output = '';
            } else{
            if($total_row > 0){
                $uf = $_SESSION["name"];
                $utf = $row["username"];
                $output = 
        <<<EOT
                <form method="post" action="../profile/delfollow.php">
                <button class="btn btn-danger">
                <i class="glyphicon glyphicon-plus">
                </i>UnFollow</button>
                <input type="hidden" name="follower" id="follower" value="$uf">
                <input type="hidden" name="to_del_follow" id="to_del_follow" value="$utf">
                </form>
        EOT;
            } else{
                $uf = $_SESSION["name"];
                $utf = $row["username"];
                $output = 
        <<<EOT
                <form method="post" action="../profile/dofollow.php">
                <button class="btn vhmbtn">
                <i class="glyphicon glyphicon-plus">
                </i>Follow</button>
                <input type="hidden" name="follower" id="follower" value="$uf">
                <input type="hidden" name="to_follow" id="to_follow" value="$utf">
                </form>
        EOT;
            }
        }
        return $output;
    }
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }
