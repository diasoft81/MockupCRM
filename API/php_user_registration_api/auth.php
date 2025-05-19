<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function auth_required() {
    $headers = getallheaders();
    $auth = $headers['Authorization'] ?? '';
    $token = str_replace('Bearer ', '', $auth);

    if (!$token) {
        http_response_code(401);
        echo json_encode(["error" => "No token provided"]);
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid token"]);
        exit;
    }
}
