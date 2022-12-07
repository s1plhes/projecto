<?php
session_start();
include "../modules/dbconnect.php";
$a = $_POST["status"];
$b = $_SESSION["id"];
$query = "INSERT INTO user_status (status_text, user_id) VALUES (\"$a\", \"$b\")";
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

  