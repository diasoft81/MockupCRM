<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$relatif_path = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
	$relatif_path = $data["relatif_path"];
} else {
	$relatif_path = $_GET["relatif_path"];
}    

$relatif_path = trim($relatif_path, "/\\"); // Pastikan tidak ada slash di awal/akhir
if (!isset($relatif_path)) {
	echo json_encode(["success" => false, "message" => "relatif_path is required"]);
	exit;
}

$base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu"; // Sesuaikan path root

// Pastikan target path valid dan ada
$target_dir = realpath($base_dir . DIRECTORY_SEPARATOR . $relatif_path);

if (!$target_dir || strpos($target_dir, realpath($base_dir)) !== 0) {
	echo json_encode(["success" => false, "message" => "Invalid path: " . $target_dir]);
	exit;
}

function scanFolder($dir)
{
	// Buat folder jika belum ada
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true); // Buat folder dengan izin penuh dan bersifat rekursif
    }
	
	$files = [];
	$items = scandir($dir);

	foreach ($items as $item) {
		if ($item === "." || $item === "..") continue;

		$full_path = $dir . DIRECTORY_SEPARATOR . $item;
		$file_info = [
			"name" => $item,
			"path" => str_replace($_SERVER['DOCUMENT_ROOT'], "", $full_path),
			"is_dir" => is_dir($full_path),
			"size" => is_file($full_path) ? filesize($full_path) : null,
			"last_modified" => date("Y-m-d H:i:s", filemtime($full_path))
		];

		if (is_dir($full_path)) {
			$file_info["children"] = scanFolder($full_path);
		}

		$files[] = $file_info;
	}

	return $files;
}

$result = scanFolder($target_dir);
echo json_encode(["success" => true, "files" => $result]);

?>
