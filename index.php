<?php
session_start();
require "db.php";

// if not login, redirecting to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query user's tasks
// 1. prepare sql statement and bind value
$stmt = $conn->prepare("SELECT id, title, status FROM tasks WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
// 2. execute
$stmt->execute();
// 3. get result
$result = $stmt->get_result();

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

        <h3>Add new task</h3>
        <form method="POST" action="task_create.php">
            <input type="text" name="title" required />
            <button type="submit">Add</button>
        </form>

        <h3>My tasks</h3>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li><?php echo $row['title']; ?> | <?php echo $row['status']; ?> | <a href="task_update.php?id=<?php echo $row['id']; ?>">Done</a> <a href="task_delete.php?id=<?php echo $row['id']; ?>">Delete</a></li>
            <?php endwhile; ?>
        </ul>
    </div>

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>