<?php
session_start();
include "../modules/dbconnect.php";
$a = mysqli_real_escape_string(conn,$_POST["follower"]);
$b = mysqli_real_escape_string(conn,$_POST["to_del_follow"]);
$query = "DELETE FROM followers WHERE
the_followed=\"$b\" AND the_follower=\"$a\"";
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
