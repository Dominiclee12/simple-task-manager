<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // assign values from form to variable to insert
    // when creating i need user_id and title
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];

    // prepare sql statement, bind value and execute
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $title);
    $stmt->execute();
}

header("Location: index.php");
exit();
