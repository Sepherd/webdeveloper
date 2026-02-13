<?php
require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/routing.php';
sessionChecker();

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