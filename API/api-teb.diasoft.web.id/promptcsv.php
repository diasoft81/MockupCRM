<?php
// API untuk menerima prompt dan mengirimkan file CSV hasil dari OpenAI

$api_key = getenv('OPENAI_API_KEY');
$openai_endpoint = 'https://api.openai.com/v1/chat/completions';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt'])) {
    $prompt = trim($_POST['prompt']);

    if (empty($prompt)) {
        http_response_code(400);
        echo json_encode(["error" => "Prompt tidak boleh kosong."]);
        exit;
    }

    // Kirim prompt ke OpenAI
    $data = [
        "model" => "gpt-4.1",
        "messages" => [
            ["role" => "system", "content" => "Kamu adalah analis data profesional yang menghasilkan data dalam format CSV."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.7
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $openai_endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($http_status !== 200 || !isset($result['choices'][0]['message']['content'])) {
        http_response_code(500);
        echo json_encode([
            "error" => "Gagal mengambil data dari OpenAI",
            "details" => $result
        ]);
        exit;
    }

    $csv = trim($result['choices'][0]['message']['content']);
    
    // Set header supaya browser langsung download CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="hasil_openai.csv"');
    echo $csv;
    exit;
} else {
    http_response_code(400);
    echo json_encode(["error" => "Gunakan metode POST dan sertakan parameter: prompt"]);
}
?>
