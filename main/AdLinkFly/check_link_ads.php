<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT id, alias, ad_type FROM links WHERE user_id = 21");
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($links as $link) {
    echo "ID: " . $link['id'] . " - Alias: " . $link['alias'] . " - Ad Type: " . $link['ad_type'] . "\n";
}
