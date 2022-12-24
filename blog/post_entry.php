<?php

include "../modules/functions.php";
if(isset(($_SESSION["loggedin"]))){
//GET LAST ID
$sqlGetLastId = engine->run("SELECT * FROM blog ORDER BY id DESC LIMIT 1");
$lastId = $sqlGetLastId->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['Submit'])) 
{
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./images/" . $filename;
    $authorname = trim($_SESSION['name']); //getting data to vars
    $title = trim($_POST["title"]); //getting data to vars
    $text = $_POST["editor"]; //getting data to vars
    $newtext = str_replace(array("&#039;"), array("'"), $text);
    $description = trim($_POST["description"]); //getting data to vars
    //Inster all the data
    $data = [
        'title' => $title,
        'author' => $authorname,
        'text' => $text,
        'date' => date("Y-m-d h:i:sa"),
        'description' => $description,
        'image' => $filename 
    ];
    $db->insert('blog', $data);
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
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
