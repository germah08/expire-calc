<?php
require 'db.php';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;

$pdo->beginTransaction();

$stmt = $pdo->prepare("
SELECT * FROM TICKETENATTENTE
WHERE TRAITE = 0
ORDER BY DATECREATION ASC
LIMIT :lim
FOR UPDATE
");
$stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$tickets) {
    echo "EMPTY";
    exit;
}

$ids = array_column($tickets, 'ID');
$idList = implode(",", $ids);

$pdo->prepare("
UPDATE TICKETENATTENTE
SET TRAITE = 2, DATETRAITEMENT = NOW()
WHERE ID IN ($idList)
")->execute();

$pdo->commit();

foreach ($tickets as $t) {
    echo $t['ID']."|".$t['PSEUDO']."|".$t['CODETARIF']."\n";
}