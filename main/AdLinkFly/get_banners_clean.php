<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$names = ['banner_728x90', 'banner_468x60', 'banner_336x280'];
foreach ($names as $name) {
    $stmt = $pdo->prepare("SELECT value FROM options WHERE name = ?");
    $stmt->execute([$name]);
    $opt = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "$name: " . ($opt ? $opt['value'] : 'NOT FOUND') . "\n";
}
