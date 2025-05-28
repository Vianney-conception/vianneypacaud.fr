<?php
session_start();
$file = __DIR__ . '/chat.txt';

if (!isset($_SESSION['chat_user'])) {
    $_SESSION['chat_user'] = 'Visiteur' . rand(100,999);
}

if ($_GET['action'] === 'send' && isset($_POST['message'])) {
    $msg = strip_tags($_POST['message']);
    $user = $_SESSION['chat_user'];
    $time = date('H:i');
    $line = json_encode(['user' => $user, 'text' => $msg, 'time' => $time]) . PHP_EOL;
    file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    exit;
}

if ($_GET['action'] === 'get') {
    $lines = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    $msgs = [];
    foreach (array_slice($lines, -50) as $line) {
        $msgs[] = json_decode($line, true);
    }
    header('Content-Type: application/json');
    echo json_encode($msgs);
    exit;
}
?>
