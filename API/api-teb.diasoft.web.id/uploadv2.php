<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"]) && isset($_POST["email"]) ) {
    $email = $_POST["email"];

    // Format folder berdasarkan email dan UUID
    $safeEmail = preg_replace("/[^a-zA-Z0-9]/", "_", $email); // Ganti karakter khusus dengan "_"
    $target_dir = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu/" . $safeEmail . "/" ;

    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Simpan file
    $file = $_FILES["file"];
    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        echo json_encode(["success" => true, "message" => "File uploaded successfully!", "path" => $target_file]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload file."]);
    }
}else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Dapatkan input dari request body
    $data = json_decode(file_get_contents("php://input"), true);
	error_log("Email: " . $data["email"]);
	error_log("Filename: " . $data["filename"]);

    if (isset($data["email"]) && isset($data["filename"])) {
        $email = $data["email"];
        $filename = basename($data["filename"]); // Hindari traversal direktori

        $safeEmail = preg_replace("/[^a-zA-Z0-9]/", "_", $email);
        $target_file = "/home/lzoymcsd/app/metadata.bankdata.web.id/menu/" . $safeEmail . "/" . $filename;

        if (file_exists($target_file)) {
            if (unlink($target_file)) {
                echo json_encode(["success" => true, "message" => "File deleted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete file."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "File not found."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request parameters."]);
    }
} 
else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
