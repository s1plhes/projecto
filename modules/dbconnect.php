<?php
const servername = "localhost";
const username = "root";
const password = "";
const dbname ="web";
// Create connection
// Create connection
const conn = new mysqli(servername, username, password, dbname);
// Check connection
// Check connection
date_default_timezone_set("America/Caracas");

if (!conn) {
  die("Connection failed: " . mysqli_connect_error());
}
