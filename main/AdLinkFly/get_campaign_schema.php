<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("DESCRIBE campaigns");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo $col['Field'] . " - " . $col['Type'] . "\n";
}

$stmt = $pdo->query("SELECT * FROM campaigns WHERE id = 6");
$campaign = $stmt->fetch(PDO::FETCH_ASSOC);
echo "--- Campaign 6 values ---\n";
foreach ($campaign as $k => $v) {
    echo "$k: $v\n";
}
