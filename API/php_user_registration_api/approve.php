<?php
require 'config.php';
require 'mailer.php';

$token = $_GET['token'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM pending_users WHERE token = ?");
$stmt->execute([$token]);
$pending = $stmt->fetch();

if (!$pending) {
    http_response_code(404);
    echo "Invalid or expired token.";
    exit;
}

$role_stmt = $pdo->prepare("SELECT id FROM roles WHERE name = ?");
$role_stmt->execute([$pending['preferred_role']]);
$role = $role_stmt->fetch();

if (!$role) {
    echo "Invalid role.";
    exit;
}

$user_stmt = $pdo->prepare("INSERT INTO users (id, name, email, password_hash, role_id) VALUES (UUID(), ?, ?, ?, ?)");
$user_stmt->execute([$pending['name'], $pending['email'], $pending['password_hash'], $role['id']]);

$pdo->prepare("DELETE FROM pending_users WHERE token = ?")->execute([$token]);
send_email($pending['email'], 'Registration Approved', 'Your account has been approved.', '');

echo "User approved and activated.";
