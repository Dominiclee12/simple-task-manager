<?php
session_start();
header("Content-Type: application/json");
require 'db.php';

// validate user logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // retrieve tasks
    case "GET":
        $stmt = $conn->prepare("SELECT id, title, status FROM tasks WHERE user_id=? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["success" => true, "tasks" => $tasks]);
        break;

    // create task
    case "POST":
        // read raw HTTP request body and decode them into associative array for PHP
        $data = json_decode(file_get_contents("php://input"), true);
        $title = $data['title'];

        if (empty($title)) {
            echo json_encode(["success" => false, "message" => "title is required"]);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $title);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Task added"]);
        break;

    // update task
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $task_id = $data['id'] ?? 0;
        $status = $data['status'] ?? 'todo';

        $stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=? AND user_id=?");
        $stmt->bind_param("sii", $status, $task_id, $user_id);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Task updated"]);
        break;

    // delete task
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        $task_id = $data['id'] ?? 0;

        $stmt = $conn->prepare("DELETE tasks WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "Task deleted"]);
        break;

    default:
        echo json_encode(["success" => false, "message" => "Invalid method"]);
}
