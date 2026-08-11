<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT * FROM campaign_items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($items as $item) {
    echo "Item ID: {$item['id']} - Camp ID: {$item['campaign_id']} - Country: {$item['country']} - Purchase: {$item['purchase']} - Views: {$item['views']}\n";
}
