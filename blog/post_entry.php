<?php
use PhpParser\Node\Expr\Isset_;
session_start();
include "../modules/dbconnect.php";
if(isset(($_SESSION["loggedin"]))){
//GET LAST ID
$sqlgetlastid = mysqli_query(conn,"SELECT * FROM blog  ORDER BY id DESC LIMIT 1");
$lastid = mysqli_fetch_array($sqlgetlastid);
$userID = $lastid["id"]; //Setting the array to varchar
$authorname = $_SESSION['name']; //getting data to vars
$title = $_POST["title"]; //getting data to vars
$text = $_POST["editor"]; //getting data to vars
$newtext = str_replace(array("&#039;"), array("'"), $text);
$desc = $_POST["description"]; //getting data to vars

if(isset($_POST['Submit'])) 
{
    $title = $_POST["title"]; //getting data to vars
    $text = $_POST["editor"]; //getting data to vars
    $desc = $_POST["description"]; //getting data to vars
    //Inster all the data
    $sql = mysqli_query(conn,"INSERT INTO blog(title, author, text, date, description)
    VALUES ('$title', '$authorname', '$text', NOW(), '$desc')");
    //HI
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $newid = $lastid["id"];
    $sumid = $newid + 1;
    $extra = 'entry.php?page_id=';
    header("Location: http://$host$uri/$extra$sumid");
    exit;
}
} else {
$host  = $_SERVER['HTTP_HOST'];
header("Location : $host");
}
//Coded by Siplhes 04/12/2022 at 02:54
?>
