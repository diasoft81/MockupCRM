<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Ambil parameter dari URL
$email = isset($_GET["email"]) ? $_GET["email"] : null;
$json_file = isset($_GET["json_file"]) ? $_GET["json_file"] : null;

if (!$email || !$json_file) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

// Konversi email agar aman dijadikan path
$email_path = str_replace(["@", "."], "_", $email);

// Tentukan direktori penyimpanan
$base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu";

// Bentuk full path ke file JSON
$target_file = $base_dir . DIRECTORY_SEPARATOR . $email_path . DIRECTORY_SEPARATOR . $json_file;

// Log untuk debugging
//error_log("Requested Email: " . $email);
//error_log("Requested JSON File: " . $json_file);
//error_log("Target File Path: " . $target_file);

// Cek apakah file ada
if (!file_exists($target_file)) {
    error_log("File not found: " . $target_file);
    echo json_encode(["success" => false, "message" => "File not found"]);
    exit;
}

// Baca isi file
$content = file_get_contents($target_file);
$data = json_decode($content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Invalid JSON format"]);
    exit;
}

echo json_encode(["success" => true, "data" => $data]);

?>
