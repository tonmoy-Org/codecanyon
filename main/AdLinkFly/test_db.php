<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly", "adlinkfly_user", "AdlinkPass2024");
$stmt = $pdo->prepare("SELECT id, username, email, publisher_earnings, referral_earnings FROM users WHERE email = :email");
$stmt->execute(['email' => 'tutulnaj@gmail.com']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "USER_FOUND\n";
    echo "ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "Publisher Earnings: " . $user['publisher_earnings'] . "\n";
} else {
    echo "USER_NOT_FOUND\n";
}
