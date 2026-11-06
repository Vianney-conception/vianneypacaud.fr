<?php
declare(strict_types=1);
session_start();
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Type: application/json; charset=utf-8");
$encryptionKey = 'xHdxKqFDmp7K7Bjntxgr5mKrLmCdqF38nA9RTNqj'; 
$cipherMethod  = 'aes-256-gcm';
function encryptField(string $data, string $key, string $method): ?array {
    if ($data === '') {
        return null;
    }
    $ivlen = openssl_cipher_iv_length($method);
    $iv = random_bytes($ivlen);
    $tag = '';
    $ciphertext = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv, $tag);
    
    if ($ciphertext === false) {
        return null;
    }

    return [
        'iv'         => base64_encode($iv),
        'ciphertext' => base64_encode($ciphertext),
        'tag'        => base64_encode($tag)
    ];
}
final class VisitorInspector
{
    private string $ip;
    private string $serverIp;

    public function __construct(string $ip, string $serverIp)
    {
        $this->ip = $ip;
        $this->serverIp = $serverIp;
    }

    public function isTorExitNode(): bool
    {
        if (!filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        $reversedIp = implode('.', array_reverse(explode('.', $this->ip)));
        $reversedServerIp = implode('.', array_reverse(explode('.', $this->serverIp)));
        
        $query = "{$reversedIp}.80.{$reversedServerIp}.ip-port.exitlist.torproject.org";

        $record = gethostbyname($query);
        return $record === '127.0.0.2';
    }

    public function inspectServerHeaders(): bool
    {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (preg_match('/bot|crawl|spider|slurp|curl|wget|python|java|headless/i', $ua)) {
            return true;
        }

        $proxyHeaders = ['HTTP_VIA', 'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR'];
        foreach ($proxyHeaders as $header) {
            if (!empty($_SERVER[$header])) {
                return true; 
            }
        }

        return false;
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Déconnexion effectuée avec succès.']);
    exit;
}

$clientIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$serverIp = $_SERVER['SERVER_ADDR'] ?? '127.0.0.1';
$inspector = new VisitorInspector($clientIp, $serverIp);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
    exit;
}

if (empty($_SESSION['security_verified']) || $_SESSION['security_verified'] !== true) {
    $isTor = $inspector->isTorExitNode();
    $serverBotDetected = $inspector->inspectServerHeaders();

    $jsPayload = isset($_POST['js_fingerprint']) ? (json_decode($_POST['js_fingerprint'], true) ?? []) : [];
    $isWebdriver = !empty($jsPayload['webdriver']);
    $isChromeHeadless = ($jsPayload['is_chrome'] ?? false) && (($jsPayload['plugins_count'] ?? 0) === 0);
    $clientBotDetected = $isWebdriver || $isChromeHeadless;

    if ($isTor || $serverBotDetected || $clientBotDetected) {
        $_SESSION['security_verified'] = false;
        http_response_code(403);
        echo json_encode([
            'status' => 'blocked', 
            'reason' => $isTor ? 'Tor detected' : 'Automated traffic detected'
        ]);
        exit;
    }

    $_SESSION['security_verified'] = true;
}

$nom     = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (!empty($message)) {
    date_default_timezone_set('Europe/Paris');
    $dateEnvoi = date('Y-m-d H:i:s');
    $nouveauMessage = [
        'date'    => $dateEnvoi,
        'nom'     => encryptField($nom, $encryptionKey, $cipherMethod),
        'email'   => encryptField($email, $encryptionKey, $cipherMethod),
        'message' => encryptField($message, $encryptionKey, $cipherMethod)
    ];

    $fichierJson = 'messages.json';
    $messages = [];
    if (file_exists($fichierJson)) {
        $contenuFichier = file_get_contents($fichierJson);
        $decoded = json_decode($contenuFichier, true);
        if (is_array($decoded)) {
            $messages = $decoded;
        }
    }
    $messages[] = $nouveauMessage;
    file_put_contents($fichierJson, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Message enregistré et chiffré avec succès.']);
    exit;
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Le champ message est vide.']);
    exit;
}