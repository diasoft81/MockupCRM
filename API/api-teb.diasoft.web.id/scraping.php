<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['urls']) || !isset($input['script'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing urls or script']);
    exit;
}

$urls = $input['urls'];
$script = $input['script'];

// Simpan URL ke file sementara
$urlsFile = tempnam(sys_get_temp_dir(), 'urls_') . '.json';
file_put_contents($urlsFile, json_encode($urls));

// Simpan script Python ke file sementara
$scriptFile = tempnam(sys_get_temp_dir(), 'scraper_') . '.py';
file_put_contents($scriptFile, $script);

// Jalankan script Python
$command = escapeshellcmd("python3 $scriptFile $urlsFile");
$output = shell_exec($command);

// Hapus file sementara
@unlink($urlsFile);
@unlink($scriptFile);

// Kembalikan hasil output
echo json_encode(['output' => $output]);
