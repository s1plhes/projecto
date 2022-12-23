<?php

include "../modules/functions.php";

if(isset(($_SESSION["loggedin"]))){

$desc = $_POST["description"]; //getting data to vars
$editingid = $_GET['page_id'];

if(isset($_POST['Submit'])) 
{
    $title = trim($_POST["title"]); //getting data to vars
    $text =  htmlspecialchars($_POST["editor"]); //getting data to vars
    $desc = trim( htmlspecialchars($_POST["description"])); //getting data to vars
    //update all the data
    $data = [
    'tile' => $title,
    'text' => $text,
    'description' => $desc,
    ];
    $where = ['id' => $editingid];
    engine->update('blog', $data, $where);
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
