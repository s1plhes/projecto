<?php 

include "../page.php";
template_header("oderder");

    $id = $_GET['id'];
    $thisUser = $_SESSION['name'];
    echo <<<admin
    <style>
    body{
      background-color: #271b37; 
      color: white;
    }</style>
    <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="myOrders"> 
    admin;
    checkUserOrder($id);
    echo <<<admin
    </div>
    </div>
    admin;
    ?>

    