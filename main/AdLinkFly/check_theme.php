<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT name, value FROM options WHERE name IN ('theme', 'member_theme', 'admin_theme')");
$opts = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($opts as $opt) {
    echo "{$opt['name']}: {$opt['value']}\n";
}
