<?php
session_start();

include "../page.php";
$postid = $_GET['page_id'];
$query = "DELETE FROM blog WHERE id=$postid";
if (engine->run($query)) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
mysqli_close($conn);
