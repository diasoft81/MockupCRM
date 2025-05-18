<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/octet-stream");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Ambil parameter dari URL
$file_name = isset($_GET["file_name"]) ? $_GET["file_name"] : null;

if (!$file_name) {
    echo json_encode(["success" => false, "message" => "Missing file_name parameter"]);
    exit;
}

// Tentukan direktori penyimpanan
$base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/widgets";

// Bentuk full path ke file
$target_file = $base_dir . DIRECTORY_SEPARATOR . $file_name;

// Cek apakah file ada
if (!file_exists($target_file)) {
    error_log("File not found: " . $target_file);
    echo json_encode(["success" => false, "message" => "File not found"]);
    exit;
}

// Baca isi file sebagai byte array
$content = file_get_contents($target_file);
if ($content === false) {
    echo json_encode(["success" => false, "message" => "Failed to read file"]);
    exit;
}

// Set header agar browser mendownload file
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Content-Length: " . strlen($content));
echo $content;
?>
