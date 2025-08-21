<?php
session_start();
header("Content-Type: application/json");
require '../db.php';

// validate user logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "not authorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        // retrieve tasks
        $stmt = $conn->prepare("SELECT id, title, status FROM tasks WHERE user_id=? ORDER BY status ASC, created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode(["success" => true, "data" => $tasks]);
        break;

    case "POST":
        // create task
        $data = json_decode(file_get_contents("php://input"), true); // read raw HTTP request body and decode them into associative array for PHP
        $title = $data['title'];

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "title is required"]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $title);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "task added"]);
        break;

    case "PUT":
        // update task
        $data = json_decode(file_get_contents("php://input"), true);
        $task_id = $data['id'] ?? 0;
        $status = $data['status'];

        $stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=? AND user_id=?");
        $stmt->bind_param("sii", $status, $task_id, $user_id);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "task updated"]);
        break;

    case "DELETE":
        // delete task
        $data = json_decode(file_get_contents("php://input"), true);
        $task_id = $data['id'] ?? 0;

        $stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "task deleted"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "invalid method"]);
}
