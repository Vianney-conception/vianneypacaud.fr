<?php
declare(strict_types=1);
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
if (!isset($_GET['c']) || empty(trim($_GET['c']))) {
    http_response_code(404);
    include '../Articles/404.php';
    exit;
}
$encryptionKey = trim($_GET['c']);
$cipherMethod  = 'aes-256-gcm';
$fichierJson   = 'messages.json';
function decryptField(?array $encryptedField, string $key, string $method): string|false {
    if (!$encryptedField || !isset($encryptedField['iv'], $encryptedField['ciphertext'], $encryptedField['tag'])) {
        return '';
    }
    $iv         = base64_decode($encryptedField['iv']);
    $ciphertext = base64_decode($encryptedField['ciphertext']);
    $tag        = base64_decode($encryptedField['tag']);
    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv, $tag);
}
if (!file_exists($fichierJson)) {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(200);
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}
$contenuFichier = file_get_contents($fichierJson);
$messagesBruts = json_decode($contenuFichier, true);
if (!is_array($messagesBruts)) {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(200);
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}
$messagesDechiffres = [];
$keyIsValid = true;

foreach ($messagesBruts as $msg) {
    $nomDecrypted     = '';
    $emailDecrypted   = '';
    $messageDecrypted = '';
    if (isset($msg['nom']) && is_array($msg['nom'])) {
        $nomDecrypted = decryptField($msg['nom'], $encryptionKey, $cipherMethod);
        if ($nomDecrypted === false) { $keyIsValid = false; break; }
    }
    if (isset($msg['email']) && is_array($msg['email'])) {
        $emailDecrypted = decryptField($msg['email'], $encryptionKey, $cipherMethod);
        if ($emailDecrypted === false) { $keyIsValid = false; break; }
    }
    if (isset($msg['message']) && is_array($msg['message'])) {
        $messageDecrypted = decryptField($msg['message'], $encryptionKey, $cipherMethod);
        if ($messageDecrypted === false) { $keyIsValid = false; break; }
    }
    $messagesDechiffres[] = [
        'date'    => $msg['date'] ?? '',
        'nom'     => $nomDecrypted,
        'email'   => $emailDecrypted,
        'message' => $messageDecrypted
    ];
}
if (!$keyIsValid && !empty($messagesBruts)) {
    http_response_code(403);
    include '../Articles/404.php';
    exit;
}
header("Content-Type: application/json; charset=utf-8");
http_response_code(200);
echo json_encode($messagesDechiffres, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;