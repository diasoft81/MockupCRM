<?php
require 'config.php';
require 'mailer.php';

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name']);
$email = trim($data['email']);
$password = password_hash($data['password'], PASSWORD_BCRYPT);
$preferred_role = trim($data['preferred_role']);

$token = bin2hex(random_bytes(16));
$stmt = $pdo->prepare("INSERT INTO pending_users (id, name, email, password_hash, preferred_role, token) VALUES (UUID(), ?, ?, ?, ?, ?)");
$stmt->execute([$name, $email, $password, $preferred_role, $token]);

$approval_link = "https://example.com/api/approve.php?token=$token";
send_email('admin@example.com', 'User Registration Approval', "Approve new user: $name ($email)", $approval_link);

echo json_encode(["status" => "pending", "message" => "Registration submitted for approval."]);
