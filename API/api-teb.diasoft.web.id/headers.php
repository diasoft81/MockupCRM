<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$username = 'ofpxdhwd_teb';
$password = 'SatuApril2024@teb';
$database = 'ofpxdhwd_crm_teb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Get table name from the URL
if (!isset($_GET['tablename']) || empty($_GET['tablename'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Table name is required']);
    exit();
}

$tableName = $conn->real_escape_string($_GET['tablename']);

// Fetch column information from the table
$query = "SHOW COLUMNS FROM `$tableName`";
$result = $conn->query($query);

if (!$result) {
    http_response_code(404);
    echo json_encode(['error' => 'Table not found']);
    exit();
}

$columns = [];
while ($row = $result->fetch_assoc()) {
    $columnName = $row['Field'];
    $title = preg_replace('/(?<!^)([A-Z])/', ' $1', ucfirst($columnName));
    $columns[] = [
        'Name' => $columnName,
        'Title' => $title
    ];
}

echo json_encode($columns, JSON_PRETTY_PRINT);

$conn->close();
?>
