<?php
session_start();
include "../modules/dbconnect.php";
$reply_text = $_POST["status"];
$reply_id = $_SESSION["id"];

$data = [
  'status_text' => $reply_text,
  'user_id' => $reply_id
];

if (engine->insert('user_status', $data)) {
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

  