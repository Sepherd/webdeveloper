<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['account']) && $_GET['page'] !== 'login') {
    header('Location: index.php?page=login');
    exit;
}
$account = $_SESSION['account'];
$theme = $account['theme'] ?? '';
function echoAccount($key)
{
    global $account;
    return htmlspecialchars($account[$key]);
}
?>
<div class="p-8" data-theme="<?php echo $account['theme'] ?? 'default'; ?>">
    <h1 class="text-primary-500">Benvenuto, <?php echo echoAccount('name'); ?>!</h1>
</div>