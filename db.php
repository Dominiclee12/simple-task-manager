<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "task_manager";

// create connection
$conn = new mysqli($host, $user, $pass, $db_name);

// test connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
