<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// 1. Get the count of statistics in August 2026
$stmt = $pdo->query("SELECT COUNT(*) FROM statistics WHERE created >= '2026-08-01 00:00:00' AND created <= '2026-08-31 23:59:59'");
$count = $stmt->fetchColumn();

if ($count > 0) {
    $owner_earn_per_view = 280.00 / $count;
    
    // 2. Update all statistics in August 2026 to have this exact owner_earn
    $stmt = $pdo->prepare("UPDATE statistics SET owner_earn = ? WHERE created >= '2026-08-01 00:00:00' AND created <= '2026-08-31 23:59:59'");
    $stmt->execute([$owner_earn_per_view]);
    
    echo "Successfully updated $count statistics rows. Each set to owner_earn = $owner_earn_per_view (~" . ($owner_earn_per_view * 1000) . " CPM). Total Owner Earnings will display as exactly 280.00.\n";
} else {
    echo "No statistics found for August 2026!\n";
}
