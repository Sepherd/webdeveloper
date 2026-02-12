<?php
session_start();

$accounts = require __DIR__ . '/accounts.php';
$accountList = array_map(function ($acc) {
    return strtolower(str_replace(' ', '-', $acc['name']));
}, $accounts);
$selected = $_POST['account'] ?? null;

if ($selected && in_array($selected, $accountList)) {
    $accountIndex = array_search($selected, $accountList);
    $_SESSION['account'] = $accounts[$accountIndex];
    $_SESSION['account_key'] = $selected;
    echo json_encode(['success' => true]);
    exit;
}
echo json_encode(['success' => false, 'message' => 'Account non valido']);
exit;
