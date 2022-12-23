<?php
session_start();
include "../modules/dbconnect.php";
//setting variables
$reply_text = $_POST["reply_text"];
$reply_id = $_SESSION["id"];
$parent_id = $_POST["parent_id"];
//setting variables

$data = [
  'status_text' => $reply_text,
  'user_id' => $reply_id,
  'parent_id' => $parent_id
];

if (engine->insert('user_status', $data)) {
   $URL_STATUS = $_SERVER['HTTP_REFERER'];
    header("Location: $URL_STATUS");
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
mysqli_close($conn);

  