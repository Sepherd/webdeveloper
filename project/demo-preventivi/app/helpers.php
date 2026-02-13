<?php

function echoAccount($key)
{
    $account = $_SESSION['demo']['account'] ?? [];
    return htmlspecialchars($account[$key] ?? '');
}

function filterData($id, $data)
{
    return array_filter($data, function ($item) use ($id) {
        return $item['userId'] == $id;
    });
}

function filterSelectedAccount($name, $accounts)
{
    foreach ($accounts as $account) {
        if (strtolower(str_replace(' ', '-', $account['name'])) === $name) {
            return $account;
        }
    }
    return null;
}

function sessionChecker()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
