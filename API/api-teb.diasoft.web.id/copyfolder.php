<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["source_path"]) || !isset($data["target_path"])) {
        echo json_encode(["success" => false, "message" => "source_path and target_path are required"]);
        exit;
    }

    $source_path = $data["source_path"];
    $target_path = $data["target_path"];
    $mirror_mode = isset($data["mirror"]) ? (bool) $data["mirror"] : false;

    $base_dir = realpath(__DIR__ . "/../user.bankdata.web.id/");
    $full_source = realpath($base_dir . "/" . $source_path);
    $full_target = realpath($base_dir . "/" . dirname($target_path)) . "/" . basename($target_path);

    if (!$full_source || strpos($full_source, $base_dir) !== 0 || !is_dir($full_source)) {
        echo json_encode(["success" => false, "message" => "Invalid source path"]);
        exit;
    }

    if (!$full_target || strpos($full_target, $base_dir) !== 0) {
        echo json_encode(["success" => false, "message" => "Invalid target path"]);
        exit;
    }

    function copyFolder($src, $dst, $mirror = false)
    {
        if ($mirror && is_dir($dst)) {
            deleteFolder($dst);
        }

        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }

        foreach (scandir($src) as $item) {
            if ($item === "." || $item === "..") continue;

            $src_item = $src . DIRECTORY_SEPARATOR . $item;
            $dst_item = $dst . DIRECTORY_SEPARATOR . $item;

            if (is_dir($src_item)) {
                copyFolder($src_item, $dst_item, false);
            } else {
                copy($src_item, $dst_item);
                chmod($dst_item, fileperms($src_item)); // Copy permission
            }
        }
    }

    function deleteFolder($folder)
    {
        foreach (scandir($folder) as $item) {
            if ($item === "." || $item === "..") continue;

            $file = $folder . DIRECTORY_SEPARATOR . $item;
            if (is_dir($file)) {
                deleteFolder($file);
            } else {
                unlink($file);
            }
        }
        rmdir($folder);
    }

    copyFolder($full_source, $full_target, $mirror_mode);

    echo json_encode(["success" => true, "message" => "Folder copied successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
