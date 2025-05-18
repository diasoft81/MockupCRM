<?php
// Set your OpenAI API key here
$api_key = getenv('OPENAI_API_KEY');

// Check if a CSV file has been uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $csv_content = file_get_contents($_FILES['csv_file']['tmp_name']);

    // Build the prompt
    $prompt = "Imagine anda seorang profesional dan pakar yang menulis di media untuk profesional dan bisnis. buatkan ikhtisar, analisis dan narasi yang bisa menjadi content berita dari data CSV berikut:\n\n" . $csv_content;

    // Create the OpenAI API request payload
    $data = [
        "model" => "gpt-4.1",
        "messages" => [
            ["role" => "system", "content" => "Anda adalah profesional ahli analis data."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.7
    ];

    // Send the request to OpenAI API
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);
    $output_html = $response_data['choices'][0]['message']['content'] ?? 'Gagal mendapatkan narasi.';

    echo "<h2>Hasil Narasi:</h2>";
    echo $output_html;
    echo "<hr><a href='narratecsv.php'>Kembali</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Narasi CSV Otomatis</title>
</head>
<body>
    <h1>Unggah CSV untuk Dinarasikan</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <br><br>
        <button type="submit">Kirim ke AI</button>
    </form>
</body>
</html>
