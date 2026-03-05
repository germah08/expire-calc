<?php
$host = "sql213.byethost12.com";
$db   = "b12_39181647_wp536";
$user = "b12_39181647";
$pass = "7Kx2D85olrCS@";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("DB ERROR");
}