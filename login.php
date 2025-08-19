<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // SQL GET user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows() > 0) {
        $stmt->fetch();

        // verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            echo "Email/Password wrong <a href='login_form.php'>Retry</a>";
        }
    } else {
        echo "User is not exist <a href='register_form.php'>Register</a>";
    }
    $stmt->close();
}
