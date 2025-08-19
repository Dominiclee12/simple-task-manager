<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Simple Task Manager</title>
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['email']; ?>!</h2>
        <p>This is the homepage</p>
        <a href="logout.php">Logout</a>
    </div>
    
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>