<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT id, username, phone_number, whatsapp_number, mobile FROM users ORDER BY id DESC LIMIT 10");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "ID: {$user['id']} - Username: {$user['username']} - Phone: '{$user['phone_number']}' - WhatsApp: '{$user['whatsapp_number']}' - Mobile: '{$user['mobile']}'\n";
}
