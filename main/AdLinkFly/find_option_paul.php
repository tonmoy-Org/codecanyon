<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT name, value FROM options");
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($options as $opt) {
    if (stripos($opt['value'], 'Paul') !== false || stripos($opt['value'], 'Kocher') !== false) {
        echo "Option: " . $opt['name'] . " -> Value: " . $opt['value'] . "\n";
    }
}
echo "Done.\n";
