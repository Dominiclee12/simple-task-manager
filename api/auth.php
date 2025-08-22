<?php
session_start();
require "../db.php";

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "POST":
        // handle login or register
        $data = json_decode(file_get_contents("php://input"), true);
        $action = $data["action"] ?? "";
        $email = trim($data["email"]);
        $password = $data["password"];

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "email and password required"]);
            exit;
        }

        if (isset($action) && $action == "register") {
            // register
            $hashed_password = password_hash($data["password"], PASSWORD_DEFAULT);

            // todo: duplcate email validation

            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $hashed_password]);

            echo json_encode(["success" => true, "message" => "user registered"]);
        } else {
            // login
            $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email=?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($user) && count($user) > 0) {
                // verify password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $email;

                    echo json_encode(["success" => true, "message" => "login success"]);
                } else {
                    http_response_code(401);
                    echo json_encode(["success" => false, "message" => "invalid credentials"]);
                }
            } else {
                http_response_code(401);
                echo json_encode(["success" => false, "message" => "email is not yet registered"]);
            }
        }
        break;

    case "DELETE":
        session_destroy();
        echo json_encode(["success" => true, "message" => "Logged out"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "method not allowed"]);
}
