<?php
header("Content-Type: application/json; charset=utf-8");

// Konfigurasi API Key OpenAI
$api_key = getenv('OPENAI_API_KEY');
$openai_endpoint = 'https://api.openai.com/v1/chat/completions';

// Validasi input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csv_text']) && isset($_POST['title'])&& isset($_POST['filename']) && isset($_POST['reference'])) {
    $csv_text = trim($_POST['csv_text']);
    $title = trim($_POST['title']);
    $filename = trim($_POST['filename']);
    $reference = trim($_POST['reference']);

    if (empty($csv_text) || empty($filename)) {
        echo json_encode(["error" => "filename dan csv_text tidak boleh kosong."]);
        exit;
    }

    // Bersihkan nama file jadi judul (hapus ekstensi, underscore → spasi)
    $title = pathinfo($filename, PATHINFO_FILENAME);
    $title = str_replace('_', ' ', $title);

// Browsing dari "$reference" di Internet untuk konteks terkini sehingga narasi bisa memuat informasi timeline,alur,setting,tempat/lokasi yang akurat.

    // Bangun prompt yang informatif
    $prompt = <<<EOT
Berikut ini adalah data berjudul: "$title".
Filename: $filename
Referensi: $reference
Data dalam format CSV:
$csv_text

Buatlah analisis dan narasi jurnalistik dalam Bahasa Indonesia yang cerdas, informatif, dan kontekstual berdasarkan judul dan isi data di atas.

Syarat dan ketentuan dalam narasi:
- Gunakan gaya bahasa jurnalistik yang jelas, tidak bertele-tele, dan mudah dipahami publik.
- Jangan gunakan frasa keraguan seperti "mungkin", "diperkirakan", atau "kemungkinan" kecuali benar-benar tertulis eksplisit dalam data.
- Jika ada fakta atau perbandingan menarik, sertakan dalam bentuk narasi yang bernilai berita.
- Jangan memasukkan informasi yang tidak ada dalam data.
- Hindari repetisi atau kalimat yang redundan.
- Fokuskan narasi pada insight dan analisis yang bisa ditarik langsung dari data.

EOT;

    // Kirim ke OpenAI
    $data = [
		"model" => "gpt-4.1",
        "messages" => [
            ["role" => "system", "content" => "Kamu adalah profesional ahli analis dan jurnalis media untuk profesional dan bisnis."],
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
        echo json_encode(["error" => "Gagal mendapatkan narasi dari OpenAI.", "details" => $result]);
        exit;
    }

    echo json_encode([
        "narration" => trim($result['choices'][0]['message']['content']),
        "title" => $title
    ]);
} else {
    echo json_encode(["error" => "Gunakan metode POST dan sertakan parameter: filename dan csv_text."]);
}
?>
