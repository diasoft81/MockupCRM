<?php

// Allow CORS from any origin (untuk development)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight (OPTIONS) request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load environment variables (using .env if necessary)
//require 'vendor/autoload.php';
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//$dotenv->load();

$api_key = getenv('OPENAI_API_KEY');
if (!$api_key) {
    http_response_code(500);
    echo json_encode(['error' => 'API key not configured.']);
    exit;
}

// Get input JSON
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['messages'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input. Field "messages" is required.']);
    exit;
}

// Merge with default parameters
$payload = array_merge([
    'model' => 'gpt-4',
    'temperature' => 0.2
], $input);

// Prepare cURL
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}
curl_close($ch);

// Output result
header('Content-Type: application/json');
echo $response;
