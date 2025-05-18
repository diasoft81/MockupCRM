<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu"; // Sesuaikan path root
$base_realpath = realpath($base_dir);

$relatif_path = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["relatif_path"]) || empty($data["relatif_path"])) {
        echo json_encode(["success" => false, "message" => "relatif_path is required"]);
        exit;
    }
    $relatif_path = trim($data["relatif_path"], "/\\");
} else {
    if (!isset($_GET["relatif_path"]) || empty($_GET["relatif_path"])) {
        echo json_encode(["success" => false, "message" => "relatif_path is required"]);
        exit;
    }
    $relatif_path = trim($_GET["relatif_path"], "/\\");
}

// Cegah directory traversal
if (strpos($relatif_path, "..") !== false) {
    echo json_encode(["success" => false, "message" => "Invalid relatif_path"]);
    exit;
}

$target_realpath = realpath($base_dir . DIRECTORY_SEPARATOR . $relatif_path);

// Pastikan path valid dan berada dalam base_dir
if (!$target_realpath || strpos($target_realpath, $base_realpath) !== 0) {
    echo json_encode(["success" => false, "message" => "Invalid path"]);
    exit;
}

function scanFolder($dir, $base_realpath)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $files = [];
    $items = scandir($dir);

    foreach ($items as $item) {
        if ($item === "." || $item === "..") continue;

        $full_path = $dir . DIRECTORY_SEPARATOR . $item;
        $file_info = [
            "name" => $item,
            "path" => str_replace($base_realpath, "", $full_path),
            "is_dir" => is_dir($full_path),
            "size" => is_file($full_path) ? filesize($full_path) : null,
            "last_modified" => date("Y-m-d H:i:s", filemtime($full_path))
        ];

        if (is_dir($full_path)) {
            $file_info["children"] = scanFolder($full_path, $base_realpath);
        }

        $files[] = $file_info;
    }

    return $files;
}

$result = scanFolder($target_realpath, $base_realpath);
echo json_encode(["success" => true, "files" => $result]);

?>
