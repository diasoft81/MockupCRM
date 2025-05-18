<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$target_dir = "/home/lzoymcsd/public_html/uploads/"; // Folder tempat menyimpan file
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true); // Buat folder jika belum ada
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        echo json_encode(["success" => true, "message" => "File uploaded successfully!", "path" => $target_file]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload file."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
