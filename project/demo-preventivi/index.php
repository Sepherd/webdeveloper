<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} else {
    $_SESSION = [];
    session_destroy();
    session_start();
}
require_once __DIR__ . '/app/routing.php';

if (!isset($_SESSION['account']) && $_GET['page'] !== 'login') {
    header('Location: index.php?page=login');
    exit;
}

$account = $_SESSION['account'] ?? null;
$page = $_GET['page'] ?? 'login';

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>AR | Demo Preventivi</title>
    <link href="../../src/css/demo-preventivi.css" rel="stylesheet">

</head>

<body>
    <?php loadPage($page); ?>
</body>

</html>