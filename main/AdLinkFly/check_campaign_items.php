<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->prepare("SELECT * FROM campaign_items WHERE campaign_id = ?");
$stmt->execute([6]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($items as $item) {
    print_r($item);
}
