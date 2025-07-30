<?php
header("Content-Type: text/plain");
date_default_timezone_set("Africa/Porto-Novo");

// Convertit un uptime Mikrotik (ex: 4w2d04:46:20) en secondes
function parseMikrotikDuration($str) {
    $weeks = 0;
    $days = 0;
    $timePart = $str;

    // Extraire les semaines (ex: "4w")
    if (preg_match('/^(\d+)w/', $str, $matches)) {
        $weeks = (int)$matches[1];
        $str = preg_replace('/^\d+w/', '', $str); // Retirer le segment des semaines
    }

    // Extraire les jours (ex: "2d")
    if (preg_match('/^(\d+)d/', $str, $matches)) {
        $days = (int)$matches[1];
        $str = preg_replace('/^\d+d/', '', $str); // Retirer le segment des jours
    }

    // Reste : format HH:MM:SS
    $parts = explode(':', $str);
    $h = isset($parts[0]) ? intval($parts[0]) : 0;
    $m = isset($parts[1]) ? intval($parts[1]) : 0;
    $s = isset($parts[2]) ? intval($parts[2]) : 0;

    return ($weeks * 7 * 86400) + ($days * 86400) + ($h * 3600) + ($m * 60) + $s;
}

// Assure un nom de fichier valide
function sanitize($str) {
    return preg_replace('/[^a-zA-Z0-9_-]/', '', $str);
}

// Entrées
$uptime = $_GET['uptime'] ?? '0d00:00:00';
$validity = $_GET['validity'] ?? '0d00:00:00';
$user = sanitize($_GET['user'] ?? 'unknown');

// Durées en secondes
$uptime_sec = parseMikrotikDuration($uptime);
$validity_sec = parseMikrotikDuration($validity);

// Calcul date expiration précise
$now = time();
$expire_ts = $now + ($validity_sec - $uptime_sec);
$expire_str = "Expire : " . date("d/m/Y H:i", $expire_ts);

// Réponse texte pour MikroTik
echo $expire_str;
// file_put_contents("Expire/$user.txt", $expire_str);
?>