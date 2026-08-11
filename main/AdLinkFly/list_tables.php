<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    if (stripos($table, 'campaign') !== false) {
        echo "Table: $table\n";
        
        $desc = $pdo->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($desc as $col) {
            echo "  " . $col['Field'] . " (" . $col['Type'] . ")\n";
        }
        
        echo "--- Sample values ---\n";
        $samples = $pdo->query("SELECT * FROM `$table` LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($samples as $sample) {
            print_r($sample);
        }
        echo "=====================================\n";
    }
}
