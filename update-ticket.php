<?php
require 'db.php';

$id = $_GET['id'] ?? null;
$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if (!$id) exit("ERROR");

$stmt = $pdo->prepare("
UPDATE TICKETENATTENTE
SET TRAITE = 1,
USERNAME = :u,
PASSWORD = :p
WHERE ID = :id
");

$stmt->execute([
    'u'=>$username,
    'p'=>$password,
    'id'=>$id
]);

echo "OK";