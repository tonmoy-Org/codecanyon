<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT url FROM links WHERE id = 442");
$link = $stmt->fetch(PDO::FETCH_ASSOC);
echo "URL: " . $link['url'] . "\n";
