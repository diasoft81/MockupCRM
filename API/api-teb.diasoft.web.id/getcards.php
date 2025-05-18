<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

$base_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu"; // Sesuaikan path root
$base_realpath = realpath($base_dir);
$items_per_page = 10;

$page = isset($_GET["page"]) && is_numeric($_GET["page"]) ? (int)$_GET["page"] : 1;
if ($page < 1) $page = 1;

$relatif_path = isset($_GET["relatif_path"]) ? trim($_GET["relatif_path"], "/\\") : "";
$target_realpath = realpath($base_dir . DIRECTORY_SEPARATOR . $relatif_path);

// Validasi path agar tidak keluar dari base_dir
if (!$target_realpath || strpos($target_realpath, $base_realpath) !== 0) {
    echo json_encode(["success" => false, "message" => "Invalid path"]);
    exit;
}

function getCardFiles($dir)
{
    if (!is_dir($dir)) return [];
    
    $files = [];
    foreach (scandir($dir) as $file) {
        if (strpos($file, "card-") === 0 && pathinfo($file, PATHINFO_EXTENSION) === "json") {
            $full_path = $dir . DIRECTORY_SEPARATOR . $file;
            $files[] = [
                "name" => $file,
                "path" => str_replace(realpath($GLOBALS['base_realpath']), "", $full_path),
                "size" => filesize($full_path),
                "last_modified" => filemtime($full_path)
            ];
        }
    }
    
    // Urutkan berdasarkan last_modified (terbaru ke terlama)
    usort($files, fn($a, $b) => $b['last_modified'] <=> $a['last_modified']);
    
    return $files;
}

$all_files = getCardFiles($target_realpath);
$total_files = count($all_files);
$start_index = ($page - 1) * $items_per_page;
$paginated_files = array_slice($all_files, $start_index, $items_per_page);

echo json_encode([
    "success" => true,
    "page" => $page,
    "items_per_page" => $items_per_page,
    "total_files" => $total_files,
    "files" => $paginated_files,
    "has_more" => ($start_index + $items_per_page) < $total_files
]);
?>
