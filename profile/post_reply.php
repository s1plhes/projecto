<?php
session_start();
include "../modules/dbconnect.php";
//setting variables
$a = $_POST["reply_text"];
$b = $_SESSION["id"];
$parent_id = $_POST["parent_id"];
//setting variables
$query = "INSERT INTO user_status (status_text, user_id, parent_id) VALUES (\"$a\", \"$b\", \"$parent_id\")";

if (mysqli_query(conn,$query)) {
   $URL_STATUS = $_SERVER['HTTP_REFERER'];
    header("Location: $URL_STATUS");
    exit;
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
mysqli_close($conn);

  