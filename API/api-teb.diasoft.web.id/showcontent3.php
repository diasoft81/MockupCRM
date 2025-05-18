<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Ambil parameter dari URL
$email = isset($_GET["email"]) ? $_GET["email"] : null;
$file_name = isset($_GET["file_name"]) ? $_GET["file_name"] : null;

if (!$email || !$file_name) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

// Konversi email agar aman dijadikan path
$email_path = str_replace(["@", "."], "_", $email);

// Tentukan direktori penyimpanan
$base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu";

// Bentuk full path ke file
$target_file = $base_dir . DIRECTORY_SEPARATOR . $email_path . DIRECTORY_SEPARATOR . $file_name;

// Cek apakah file ada
if (!file_exists($target_file)) {
    error_log("File not found: " . $target_file);
    echo json_encode(["success" => false, "message" => "File not found"]);
    exit;
}

// Baca isi file
$content = file_get_contents($target_file);

// Deteksi jenis file berdasarkan ekstensi
$file_info = pathinfo($target_file);
$extension = strtolower($file_info['extension']);

// Kirim file dengan header yang sesuai
switch ($extension) {
    case 'json':
        header("Content-Type: application/json");
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["success" => false, "message" => "Invalid JSON format"]);
            exit;
        }
        echo json_encode(["success" => true, "data" => $data]);
        break;
    case 'txt':
    case 'csv':
        header("Content-Type: text/plain");
        echo $content;
        break;
    case 'xml':
        header("Content-Type: application/xml");
        echo $content;
        break;
    case 'xls':
    case 'xlsx':
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        echo $content;
        break;
    case 'xlsb':
        header("Content-Type: application/vnd.ms-excel.sheet.binary.macroEnabled.12");
        echo $content;
        break;
    case 'sdf':
        header("Content-Type: application/octet-stream");
        echo $content;
        break;
    default:
        header("Content-Type: application/octet-stream");
        echo $content;
        break;
}
?>
