<?php // En tu archivo PHP que maneja la solicitud
$dotenv = parse_ini_file('apikey.env');
$apiKey = $dotenv['API_KEY'];

$hash = $_GET['hash'];
$url = "https://api.gravatar.com/v3/profiles/$hash";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
