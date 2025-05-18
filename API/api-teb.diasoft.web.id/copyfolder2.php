<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// cara panggil curl "~/copyfolder2.php?source=folder1&destination=folder2"

// Ambil parameter dari URL
$source = isset($_GET["source"]) ? $_GET["source"] : null;
$destination = isset($_GET["destination"]) ? $_GET["destination"] : null;

if (!$source || !$destination) {
    echo json_encode(["success" => false, "message" => "Missing source or destination parameter"]);
    exit;
}

// Tentukan direktori dasar (base directory)
$base_dir = "/home/ofpxdhwd";

// Bentuk full path untuk source dan destination
$full_source = $base_dir . DIRECTORY_SEPARATOR . $source . ".diasoft.web.id";
$full_destination = $base_dir . DIRECTORY_SEPARATOR . $destination . ".diasoft.web.id";

// Cek apakah source folder ada
if (!is_dir($full_source)) {
    echo json_encode(["success" => false, "message" => "Source folder not found"]);
    exit;
}

// Fungsi rekursif untuk meng-copy folder
function copyFolder($src, $dst) {
    // Buat folder tujuan jika belum ada
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    // Scan semua file dan folder dalam source
    foreach (scandir($src) as $item) {
        if ($item == '.' || $item == '..') continue;

        $src_path = $src . DIRECTORY_SEPARATOR . $item;
        $dst_path = $dst . DIRECTORY_SEPARATOR . $item;

        if (is_dir($src_path)) {
            // Rekursif jika item adalah folder
            copyFolder($src_path, $dst_path);
        } else {
            // Copy file
            copy($src_path, $dst_path);
        }
    }
}

// Panggil fungsi copy folder
try {
    copyFolder($full_source, $full_destination);
    echo json_encode(["success" => true, "message" => "Folder copied successfully"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>

