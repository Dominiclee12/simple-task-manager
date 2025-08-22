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
        $stmt = $pdo->prepare("SELECT id, title, status FROM tasks WHERE user_id=? ORDER BY status ASC, created_at DESC");
        $stmt->execute([$user_id]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $tasks]);
        break;

    case "POST":
        // create task
        $data = json_decode(file_get_contents("php://input"), true); // read raw HTTP request body and convert into assoc array (PHP)
        $title = $data['title'];

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "title is required"]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
        $stmt->execute([$user_id, $title]);

        echo json_encode(["success" => true, "message" => "task added"]);
        break;

    case "PUT":
        // update task
        $data = json_decode(file_get_contents("php://input"), true);
        $task_id = $data['id'] ?? 0;
        $status = $data['status'];

        $stmt = $pdo->prepare("UPDATE tasks SET status=? WHERE id=? AND user_id=?");
        $stmt->execute([$status, $task_id, $user_id]);

        echo json_encode(["success" => true, "message" => "task updated"]);
        break;

    case "DELETE":
        // delete task
        $data = json_decode(file_get_contents("php://input"), true);
        $task_id = $data['id'] ?? 0;

        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
        $stmt->execute([$task_id, $user_id]);

        echo json_encode(["success" => true, "message" => "task deleted"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "invalid method"]);
}
