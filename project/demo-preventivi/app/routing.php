<?php

function loadPage($page) {
    $allowedPages = [
        'login',
        'dashboard',
        'preventivi',
        'clienti'
    ];
    if (!in_array($page, $allowedPages)) {
        $page = '404';
    }
    require __DIR__ . "/../pages/{$page}.php";
}