<?php
require_once __DIR__ . '/../app/helpers.php';
sessionChecker();
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit(json_encode(["error" => "Metodo non consentito"]));
}
$ip = $_SERVER['REMOTE_ADDR'];
$cacheFile = sys_get_temp_dir() . "/rate_limit_" . md5($ip) . ".txt";
if (file_exists($cacheFile) && time() - (int)file_get_contents($cacheFile) < 60) {
    http_response_code(429);
    exit(json_encode(["error" => "Riprova tra un minuto"]));
}
// $input = json_decode(file_get_contents('php://input'), true) ?? [];
// $csrfToken = $_POST['csrf_token'] ?? $input['csrf_token'] ?? '';
// if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
//     http_response_code(403);
//     exit(json_encode(["error" => "Token di sicurezza non valido"]));
// }
$db = $_SESSION['demo'] ?? [];
$accountID = $db['account']['id'] ?? null;
if (!$accountID) {
    http_response_code(400);
    exit(json_encode(["error" => "Account non trovato"]));
}
$request = $_GET['request'] ?? '';
$requestList = ['account', 'quotes', 'service', 'clients', 'categories'];
if (!in_array($request, $requestList)) {
    http_response_code(400);
    exit(json_encode(["error" => "Richiesta non valida"]));
}
$data = filterData($accountID, $db[$request] ?? []);
echo json_encode(array_values($data));
