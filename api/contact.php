<?php
session_start();
$config = require_once __DIR__ . '/config.php';
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit(json_encode(["error" => "Metodo non consentito"]));
}

$ip = $_SERVER['REMOTE_ADDR'];
$cacheFile = sys_get_temp_dir() . "/rate_limit_" . md5($ip) . ".txt";
if (file_exists($cacheFile) && time() - (int)file_get_contents($cacheFile) < 60) {
    http_response_code(429);
    exit(json_encode(["error" => "Riprova tra un minuto"]));
}

$input = json_decode(file_get_contents('php://input'), true) ?? [];
$csrfToken = $_POST['csrf_token'] ?? $input['csrf_token'] ?? '';
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
    http_response_code(403);
    exit(json_encode(["error" => "Token di sicurezza non valido"]));
}

$nome = trim($_POST["nome"] ?? $input["nome"] ?? "");
$email = trim($_POST["email"] ?? $input["email"] ?? "");
$tipo = trim($_POST["tipo-progetto"] ?? $input["tipo-progetto"] ?? $input["tipoProgetto"] ?? "");
$messaggio = trim($_POST["messaggio"] ?? $input["messaggio"] ?? "");
$honeypot = $_POST["_gotcha"] ?? $input["_gotcha"] ?? "";

if ($honeypot !== "") {
    exit(json_encode(["success" => true]));
}

if (!$nome || !$email || !$messaggio) {
    http_response_code(400);
    exit(json_encode(["error" => "Campi obbligatori mancanti"]));
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit(json_encode(["error" => "Email non valida"]));
}
$messaggio = htmlspecialchars($messaggio, ENT_QUOTES, 'UTF-8');
$nome = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
if (strlen($nome) > 100 || strlen($email) > 254 || strlen($messaggio) > 5000) {
    http_response_code(400);
    exit(json_encode(["error" => "Dati troppo lunghi"]));
}
if (strlen($nome) < 2 || strlen($email) < 5 || mb_strlen($messaggio) < 10) {
    http_response_code(400);
    exit(json_encode(["error" => "Dati troppo brevi"]));
}

$botToken = $config['telegram']['bot_token'];
$chatId = $config['telegram']['chat_id'];
if (!$botToken || !$chatId) {
    error_log("Telegram credentials not configured");
    http_response_code(500);
    exit(json_encode(["error" => "Configurazione mancante"]));
}

$data = [
    "chat_id" => $chatId,
    "parse_mode" => "HTML",
    "text" => "<b>📩 Nuovo contatto</b>\n\n<b>Nome:</b> $nome\n<b>Email:</b> $email\n<b>Tipo:</b> $tipo\n\n<b>Messaggio:</b>\n$messaggio"
];

$ch = curl_init("https://api.telegram.org/bot$botToken/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => true
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    error_log("Telegram API error: $error");
    http_response_code(500);
    exit(json_encode(["error" => "Errore nell'invio"]));
}

file_put_contents($cacheFile, time());
echo json_encode(["success" => true]);
