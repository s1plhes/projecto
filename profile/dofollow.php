<?php
session_start();
include "../modules/dbconnect.php";
$a = $_POST["follower"];
$b = $_POST["to_follow"];
$query = "INSERT INTO followers (the_follower, the_followed) VALUES (\"$a\", \"$b\")";
if (mysqli_query(conn,$query)) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $yourid = $_SESSION['id'];
    $extra = 'index.php?userid=';
    header("Location: http://$host$uri/$extra$yourid");
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
mysqli_close($conn);

  