<?php
require_once __DIR__ . '/../app/helpers.php';
sessionChecker();

$accounts = require __DIR__ . '/accounts.php';
$selectedAccount = $_POST['account'] ?? null;
$sessionAccount = filterSelectedAccount($selectedAccount, $accounts) ?? null;


if ($sessionAccount) {
    $_SESSION['demo'] = [
        "account" => $sessionAccount,
        "clients" => filterData($sessionAccount['id'], require __DIR__ . '/clients.php'),
        "quotes" => filterData($sessionAccount['id'], require __DIR__ . '/quotes.php'),
        "service" => filterData($sessionAccount['id'], require __DIR__ . '/service.php'),
        "categories" => filterData($sessionAccount['id'], require __DIR__ . '/categories.php'),
    ];
    // $_SESSION['account_key'] = $selected;
    echo json_encode(['success' => true, 'message' => 'Login di ' . $_SESSION['demo']['account']['name'] . ' effettuato con successo']);
    exit;
}
echo json_encode(['success' => false, 'message' => 'Account non valido']);
exit;
