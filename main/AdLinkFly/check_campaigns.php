<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT id, name, ad_type, banner_size, banner_code FROM campaigns");
$campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($campaigns as $camp) {
    echo "Campaign ID: " . $camp['id'] . "\n";
    echo "Name: " . $camp['name'] . "\n";
    echo "Ad Type: " . $camp['ad_type'] . "\n";
    echo "Banner Size: " . $camp['banner_size'] . "\n";
    echo "Banner Code: " . $camp['banner_code'] . "\n";
    echo "---------------------------\n";
}
