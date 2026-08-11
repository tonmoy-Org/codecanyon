<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT name, value FROM options WHERE name LIKE '%captcha%' OR name LIKE '%recaptcha%' OR name LIKE '%hcaptcha%' OR name LIKE '%turnstile%' OR name = 'enable_captcha'");
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($options as $opt) {
    echo $opt['name'] . ": " . $opt['value'] . "\n";
}
