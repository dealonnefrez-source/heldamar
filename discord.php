<?php
// Zabezpieczenie: Twój Webhook URL jest bezpieczny na serwerze, nikt go nie wyciągnie z gry!
$webhook_url = "https://discord.com/api/webhooks/1517849796889546794/bzqRt4tE9lXQRQ5mMpmsjob7477H76S6iD30ImQ8DBC3ryC9TCvYKjWJ7IV9xFYx6bL0";

// Pobranie wiadomości wysłanej przez grę
$msg = $_GET['message'] ?? '';

// Jeśli gra nie przysłała wiadomości, przerywamy
if ($msg === '') {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

// Spakowanie wiadomości do formatu, który rozumie Discord (JSON)
$json_data = json_encode([
    "content" => $msg
]);

// Wysłanie wiadomości do Discorda (metoda cURL - niezawodna na 99% hostingów)
$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Na sam koniec wysyłamy do silnika gry malutki, przezroczysty obrazek PNG (1x1 piksel).
// Dzięki temu węzeł "Download Image" uzna, że pobieranie zakończyło się wielkim sukcesem (On Success)!
header('Content-Type: image/png');
echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
?>