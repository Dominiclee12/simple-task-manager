<?php
session_start();
require "../db.php";

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "POST":
        // handle login and register
        $data = json_decode(file_get_contents("php://input"), true);
        $action = $data["action"] ?? '';
        $email = trim($data["email"]);
        $password = $data["password"];

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "email and password required"]);
            exit;
        }


        if (isset($action) && $action == "register") {
            //register
            $password = password_hash($data["password"], PASSWORD_DEFAULT);

            // todo: duplcate email validation

            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $stmt->close();

            echo json_encode(["success" => true, "message" => "user registered"]);
        } else {
            // login
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

                    echo json_encode(["success" => true, "message" => "login success"]);
                } else {
                    http_response_code(401);
                    echo json_encode(["success" => false, "message" => "invalid credentials"]);
                }
            } else {
                http_response_code(401);
                echo json_encode(["success" => false, "message" => "email is not yet registered"]);
            }
            $stmt->close();
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
