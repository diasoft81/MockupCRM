<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data["relatif_path"]) || !isset($data["json_file"])) {
        echo json_encode(["success" => false, "message" => "relatif_path and json_file are required"]);
        exit;
    }

    $relatif_path = trim($data["relatif_path"], "/\\"); // Normalisasi path
    $json_file = basename($data["json_file"]); // Hindari path traversal
    $base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu"; // Sesuaikan root direktori

    // Gabungkan path target
    $target_file = realpath($base_dir . DIRECTORY_SEPARATOR . $relatif_path . DIRECTORY_SEPARATOR . $json_file);

    // Pastikan file valid dan berada dalam base_dir
    if (!$target_file || strpos($target_file, realpath($base_dir)) !== 0 || !file_exists($target_file)) {
        echo json_encode(["success" => false, "message" => "File not found"]);
        exit;
    }

    // Baca isi file JSON
    $content = file_get_contents($target_file);
    $json_data = json_decode($content, true);

    if ($json_data === null) {
        echo json_encode(["success" => false, "message" => "Invalid JSON format"]);
        exit;
    }

    echo json_encode(["success" => true, "content" => $json_data]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
