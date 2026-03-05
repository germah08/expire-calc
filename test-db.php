<?php

require 'db.php';

try {
    $stmt = $pdo->query("SELECT NOW() as test_time");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "✅ Connexion OK<br>";
    echo "Heure serveur DB : " . $row['test_time'];

} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage();
}