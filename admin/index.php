<?php
include("../page.php");

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

template_header("Administration centre", NULL);
admin_nav();

echo <<<admin
<style>
body{
  background-color: #271b37; 
  color: white;
}</style>

admin;
?>
<div class="row">
    <div class="col">

<?php

?>

