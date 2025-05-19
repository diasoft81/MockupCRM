<?php
require 'config.php';
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email']);
$password = trim($data['password']);

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials"]);
    exit;
}

$payload = [
    "sub" => $user['id'],
    "email" => $user['email'],
    "role" => $user['role_id'],
    "iat" => time(),
    "exp" => time() + 3600
];
$jwt = JWT::encode($payload, JWT_SECRET, 'HS256');

echo json_encode(["status" => "success", "token" => $jwt]);
