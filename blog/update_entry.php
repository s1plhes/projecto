<?php
use PhpParser\Node\Expr\Isset_;
session_start();
include "../modules/dbconnect.php";

if(isset(($_SESSION["loggedin"]))){
$title = $_POST["title"]; //getting data to vars
$text =  htmlspecialchars($_POST["editor"]); //getting data to vars
$desc = $_POST["description"]; //getting data to vars
$editingid = $_GET['page_id'];

if(isset($_POST['Submit'])) 
{
    $title = $_POST["title"]; //getting data to vars
    $text = $_POST["editor"]; //getting data to vars
    $desc = $_POST["description"]; //getting data to vars
    //Inster all the data
    $sql =  mysqli_query(conn,"UPDATE blog set title='" . $title . "', text='" . $text . "', description='" . $desc . "' WHERE id='" . $editingid . "'");
    //HI
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    $sumid = $editingid;
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
