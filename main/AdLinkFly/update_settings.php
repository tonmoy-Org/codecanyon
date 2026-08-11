<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->prepare("UPDATE options SET value = 'no' WHERE name = 'enable_captcha_shortlink'");
$stmt->execute();
echo "Shortlink captcha disabled successfully!\n";
