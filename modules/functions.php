<?php
use Vehement\PdoWrapper\Database;
session_start();
include("Database.php");
/**
 * Data base functions
 */


// make a connection to mysql here
$options = [
    //required
    'username' => 'root',
    'database' => 'web',
    //optional
    'password' => '',
    'charset' => 'utf8',
];

$db = new Database($options);
define('engine' , $db);

function clean_data($data) {
    /* trim whitespace */
    $data = trim($data);
    return $data;
}
function admin_control(){
    if(isset($_SESSION['loggedin'])){
        session_regenerate_id();
        if ($result["account_level"] = 3){
        $_SESSION["isadmin"] = true;       
        $id = $_SESSION['id'];
        $sql = engine->run("SELECT * FROM accounts WHERE id= ?",[$id])->fetch(PDO::FETCH_ASSOC);
        }   
    }   
}

function urlFetch($param)
{
    if($param)
    {   
        $id = $param;
        $sql = engine->run("SELECT * FROM accounts WHERE username = ? or id = ?", [$id, $id]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        $host  = $_SERVER['HTTP_HOST'];
        $extra = 'profile/?user=';
        $header = "http://$host/$extra";
        $url = '<a href='.$header.''.$result['username'].' class="text-decoration-none">'.$result['username'].'</a>';
        return $url;
    }
}

function profileLink($i){
    $id = $i;
    $sql = engine->run("SELECT * FROM accounts WHERE username = ? or id = ?", [$id, $id]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $userName = $result["username"];
    $extra = 'profile/?user=';
    $host  = $_SERVER['HTTP_HOST'];
    $header = "http://$host/$extra";
    $url = '<a class="text-decoration-none"href='.$header.''.$userName.'>'.$userName.'</a>';
    return $url;
}
function profileName($i){
    engine->getPdo();
    $sql = engine->run("SELECT * FROM accounts WHERE username = ? or id= ?", [$i, $i])->fetch(PDO::FETCH_ASSOC);
    $getusername = $sql["username"];
    return $getusername;
}
function gettingWrittenBlogE($i)
{
    engine->getPdo();
    $row = engine->run("SELECT COUNT(author) FROM blog WHERE author = ?",[$i])
    ->fetch(PDO::FETCH_ASSOC);
    $num = implode($row);
    return $num;
}
function get_user_status($i)
{
    engine->getPdo();
    $row = engine->run("SELECT COUNT(user_id) FROM user_status WHERE user_id = ?",[$i])
    ->fetch(PDO::FETCH_ASSOC);
    $num = implode($row);
    return $num;
}
function gettingFollowers($i){
    $u = $i;
    engine->getPdo();
    $row = engine->run("SELECT COUNT(the_follower) FROM followers WHERE the_followed = ?",[$u])
    ->fetch(PDO::FETCH_ASSOC);
    $fllwCount = implode($row);
    return $fllwCount;
}
function gettingFollowing($i){
    $u = $i;
    engine->getPdo();
    $row = engine->run("SELECT COUNT(the_followed) FROM followers WHERE the_follower = ?",[$u])
    ->fetch(PDO::FETCH_ASSOC);
    $fllwCount = implode($row);
    return $fllwCount;
}

function isFollowing($i){
    if(isset(($_SESSION["loggedin"]))){
        $sql = engine->run("SELECT * FROM accounts WHERE username = ?",[$i]);
        $row = $sql->fetch(PDO::FETCH_BOTH); 
        $user_name = $row['username'];
        $session_name = $_SESSION['name'];
        $sql = engine->run("SELECT * FROM followers WHERE the_follower = ?  AND the_followed = ?",[$session_name, $user_name]); //SQL to compare
        if($_SESSION['name'] == $row['username']){
            $output = '';
            } else{
            if($sql->rowCount() > 0){
                $uf = $_SESSION['name'];
                $utf = $row['username'];
                $output = 
        <<<EOT
                <form method="post" action="../profile/delfollow.php">
                    <button class="btn btn-danger">
                    <i class="glyphicon glyphicon-plus">
                    </i>Unfollow</button>
                    <input type="hidden" name="follower"  value="$uf">
                    <input type="hidden" name="to_del_follow" value="$utf">
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
                <input type="hidden" name="follower"  value="$uf">
                <input type="hidden" name="to_follow"  value="$utf">
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

function replied_check($i){
    $result = engine->run("SELECT * FROM user_status WHERE id = ?", [$i])->fetch(PDO::FETCH_ASSOC);
    if ($result['parent_id'] > 0){
        $replied_result = engine->run("SELECT * FROM user_status WHERE id = ?", [$result['parent_id']])->fetch(PDO::FETCH_ASSOC);
        $replied_user = profileName($replied_result['user_id']);
        $replied_status_time = time_elapsed_string($replied_result['published_date']);
        $replied_status_id = $replied_result['id'];
       return <<<replys
        <div class="reply-sub-header placeholder-glow">
        <i class="placeholder">reply to <b>$replied_user</b> on <a class="placeholder text-decoration-none" href="status.php?sid=$replied_status_id">$replied_status_time</a></i>
        </div>
replys;
    } 
}

function data_img_encode($img){ 
    return base64_decode(file_get_contents("$img"));
}

function level($lvl){
    if($lvl == 1){
        return "User";
    } elseif($lvl == 2){
        return "Moderator";
    } elseif($lvl == 3){
        return "Admin";
    }
}

function breadcrumbs($sep ='',$home = "Home"){
    $bc = '<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-veh">
    ';
    //GET HTTP Address
    $site = 'http://'.$_SERVER['HTTP_HOST'];
    $crumbs = array_filter(explode("/",$_SERVER["REQUEST_URI"]));
    $bc .='<li class="breadcrumb-item"><a href="'.$site.'">'.$home.'</a>'.$sep.'</li>';
    $nm = count($crumbs);
    $i = 1;
    foreach($crumbs as $crumb){
        $last_piece = end($crumbs);
        $link = ucfirst(str_replace(array(".php","-","_"),array("","",""),$crumb));
        //Loose last separator
        $sep = $i==$nm?'':$sep;
        //Add crumbs to the root
        $site .= '/'.$crumb;
        //check last crumb
        if ($last_piece!==$crumb){
            //make nexts
            $bc .='<li class="breadcrumb-item"><a href="'.$site.'">'.$link.'</a>'.$sep.'</li>';
             } else {
            //last crumb. do not link it
            $bc .='<li class="breadcrumb-item active" aria-current="page">'.ucfirst(str_replace(array(".php","-","_"),array("","",""),$last_piece)).'</li>';
        }
        $i++;    
    }
    $bc .='</ol>
    </nav>';
    return $bc;
}

function checkUserOrders($i){
    $userName = $i;
    $sql = engine->run("SELECT * FROM orders WHERE username = ?",[$userName]);
    if ($sql->rowCount() > 0) {
        while($result = $sql->fetch(PDO::FETCH_ASSOC)){        
            $order_id = $result['id'];
            $order_user = $result['username'];
            $order_status = $result['status'];
            $xmlData = $result['order'];
            $xml = simplexml_load_string($xmlData) or die("Error");
            $order_date = time_elapsed_string($result['date']);
            echo <<<x
            <p>Your order ID#$order_id submitted $order_date is 
            <span class="badge rounded-pill bg-light text-dark">$order_status</span>
            <button class="btn btn-veh text-light" type="button" data-bs-toggle="offcanvas" 
            data-bs-target="#offcanvas-order-$order_id-$order_user" aria-controls="offcanvasExample">
            Show order
            </button></p>

                <div class="offcanvas-veh offcanvas offcanvas-start " tabindex="-1" id="offcanvas-order-$order_id-$order_user" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Order#$order_id</h5>
                    <button type="button" class="btn-close-light text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="">
x;
            foreach ($xml->children() as $orders) {
                $item = $orders->item; 
                $quantity = $orders->quantity;
                $price = $orders->price;
                $total = $orders->total;
                $priceVES = $price * dolarPrice;
                $totalVES = $total * dolarPrice;
                $subtotal = $price * $quantity;
                echo <<<item
                <li>$quantity units of $item at  $price USD(Bs $priceVES) each for a total of  $subtotal USD(Bs $totalVES)</li>              
            item;
            }
            echo <<<x
            </div>
            </div>
          </div>     
x;
        }
    }
}

function checkUserOrder($i){
    $id = $i;
    $sql = engine->run("SELECT * FROM orders WHERE id = ?", [$id]);
    if ($sql->rowCount()> 0) {
        while($result = $sql->fetch(PDO::FETCH_ASSOC)){        
            $order_id = $result['id'];
            $order_status = $result['status'];
            $xmlData = $result['order'];
            $xml = simplexml_load_string($xmlData) or die("Error");
            $order_date = time_elapsed_string($result['date']);
            echo <<<x
            <p>Your order ID#$order_id submitted $order_date is 
            <span class="badge rounded-pill bg-light text-dark">$order_status</span>
x;
            foreach ($xml->children() as $orders) {
                $item = $orders->item; 
                $quantity = $orders->quantity;
                $price = $orders->price;
                $total = $orders->total;
                $priceVES = $price * dolarPrice;
                $totalVES = $total * dolarPrice;
                $subtotal = $price * $quantity;
                echo <<<item
                <li>$quantity units of $item at  $price USD(Bs $priceVES) each for a total of  $subtotal USD(Bs $totalVES)</li>              
            item;
            }
        }
    }
}

function themeChecker()
{
    if(isset($_SESSION['loggedin']))
    {
        if($_SESSION['theme']==1)
        {
            return '<link rel="stylesheet" href="../dark-style.css" type="text/css" charset="utf-8" />';
        }
        else
        {
            return '<link rel="stylesheet" href="../style.css" type="text/css" charset="utf-8" />';
        }
    } 
    else 
    {
        return '<link rel="stylesheet" href="../dark-style.css" type="text/css" charset="utf-8" />';
    }
}
function sendMessage($text){
    $apiToken = "";
    $data = [
        'chat_id' => 'a',
        'text' => $text,
    ];
    $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?".http_build_query($data));
    return $response;
}

function dolar(){
//Get the data from API
    $json = file_get_contents("https://s3.amazonaws.com/dolartoday/data.json", 'jsonp');
//Decode UTF-8
    $utf8 = utf8_decode($json); 
//Decode JSON
    $data = json_decode($utf8, true); 
//Store the wanted value
    $dolarToday = $data['USD']['promedio']; 
//Return it
    return $dolarToday; 
//Done!
}
function utf8ize( $mixed ) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
    return $mixed;
}
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'web';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
?>
