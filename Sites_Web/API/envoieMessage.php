<?php
// ==============================================================================
// 1. CONFIGURATION ET CLASSE DE SÉCURITÉ (PHP)
// ==============================================================================
declare(strict_types=1);
session_start();

// --- En-têtes de sécurité et format de réponse unique ---
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Type: application/json; charset=utf-8");

/**
 * Analyse les signaux du visiteur pour détecter robots et Tor.
 */
final class VisitorInspector
{
    private string $ip;
    private string $serverIp;

    public function __construct(string $ip, string $serverIp)
    {
        $this->ip = $ip;
        $this->serverIp = $serverIp;
    }

    /**
     * Vérifie si l'adresse IP est un nœud de sortie TOR via DNS (Tor DNSEL).
     */
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

    /**
     * Analyse les incohérences HTTP standards pour détecter des bots simples.
     */
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

// ==============================================================================
// 2. LOGIQUE DE TRAITEMENT (PHP)
// ==============================================================================

// Gestion de la déconnexion en JSON
if (isset($_GET['logout'])) {
    session_destroy();
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Déconnexion effectuée avec succès.']);
    exit;
}

// Initialisation de l'inspecteur
$clientIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$serverIp = $_SERVER['SERVER_ADDR'] ?? '127.0.0.1';
$inspector = new VisitorInspector($clientIp, $serverIp);

// Seules les requêtes POST sont acceptées pour traiter les formulaires ou le fingerprint
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
    exit;
}

// --- ÉTAPE DE SÉCURITÉ (Exécutée si la session n'est pas encore vérifiée) ---
if (empty($_SESSION['security_verified']) || $_SESSION['security_verified'] !== true) {
    
    // Analyse Serveur (IP & Headers)
    $isTor = $inspector->isTorExitNode();
    $serverBotDetected = $inspector->inspectServerHeaders();

    // Analyse Client (Fingerprint JS si fourni dans la requête POST)
    $jsPayload = isset($_POST['js_fingerprint']) ? (json_decode($_POST['js_fingerprint'], true) ?? []) : [];
    $isWebdriver = !empty($jsPayload['webdriver']);
    $isChromeHeadless = ($jsPayload['is_chrome'] ?? false) && (($jsPayload['plugins_count'] ?? 0) === 0);
    $clientBotDetected = $isWebdriver || $isChromeHeadless;

    // Si on détecte un bot ou Tor
    if ($isTor || $serverBotDetected || $clientBotDetected) {
        $_SESSION['security_verified'] = false;
        http_response_code(403);
        echo json_encode([
            'status' => 'blocked', 
            'reason' => $isTor ? 'Tor detected' : 'Automated traffic detected'
        ]);
        exit;
    }

    // Si le fingerprint est absent mais qu'on veut l'exiger, ou si on valide par défaut
    // (Ici on valide la session pour la suite de la requête)
    $_SESSION['security_verified'] = true;
}

// --- TRAITEMENT DU FORMULAIRE (Exécuté si la sécurité est validée) ---
$nom     = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (!empty($message)) {
    date_default_timezone_set('Europe/Paris');
    $dateEnvoi = date('Y-m-d H:i:s');
    $nouveauMessage = [
        'date'    => $dateEnvoi,
        'nom'     => $nom,
        'email'   => $email,
        'message' => $message
    ];

    $fichierJson = 'messages.json';
    $messages = [];
    if (file_exists($fichierJson)) {
        $contenuFichier = file_get_contents($fichierJson);
        $messages = json_decode($contenuFichier, true) ?? [];
    }
    $messages[] = $nouveauMessage;
    file_put_contents($fichierJson, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Message enregistré avec succès.']);
    exit;
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Le champ message est vide.']);
    exit;
}