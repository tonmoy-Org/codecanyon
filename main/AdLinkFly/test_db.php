<?php

$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$user_id = 21;

// 1. Find or create a link
$stmt = $pdo->prepare("SELECT id FROM links WHERE user_id = ? LIMIT 1");
$stmt->execute([$user_id]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$link) {
    echo "Creating dummy link...\n";
    $stmt = $pdo->prepare("INSERT INTO links (user_id, ad_type, status, url, url_hash, domain, alias, title, description, image, hits, method, created, modified) VALUES (?, 1, 1, 'https://google.com', ?, 'google.com', 'dummy', 'Dummy Link', 'Dummy Description', '', 0, 0, NOW(), NOW())");
    $stmt->execute([$user_id, sha1('https://google.com')]);
    $link_id = $pdo->lastInsertId();
} else {
    $link_id = $link['id'];
}
echo "Link ID: $link_id\n";

// 2. Delete old statistics
echo "Deleting old statistics...\n";
$stmt = $pdo->prepare("DELETE FROM statistics WHERE user_id = ?");
$stmt->execute([$user_id]);

// 3. Insert views (485,000 views batch inserted)
$batchSize = 2500;
$totalRows = 485000;
$cpm = 3.00; // $3.00 CPM
$publisher_earn_per_view = $cpm / 1000; // 0.003

echo "Inserting $totalRows views in batches of $batchSize...\n";

// Dates range: July 1 to August 11, 2026
$startDate = strtotime('2026-07-01');
$endDate = strtotime('2026-08-11');

$pdo->beginTransaction();

for ($inserted = 0; $inserted < $totalRows; $inserted += $batchSize) {
    $currentBatchSize = min($batchSize, $totalRows - $inserted);
    
    $sql = "INSERT INTO statistics (user_id, link_id, ip, country, publisher_earn, created) VALUES ";
    $placeholders = [];
    $values = [];
    
    for ($i = 0; $i < $currentBatchSize; $i++) {
        $timestamp = rand($startDate, $endDate);
        $dateStr = date('Y-m-d H:i:s', $timestamp);
        
        $placeholders[] = "(?, ?, ?, ?, ?, ?)";
        $values[] = $user_id;
        $values[] = $link_id;
        $values[] = '192.168.1.' . rand(1, 254);
        $values[] = ['US', 'CA', 'GB', 'AU', 'IN', 'BD'][rand(0, 5)];
        $values[] = $publisher_earn_per_view;
        $values[] = $dateStr;
    }
    
    $sql .= implode(', ', $placeholders);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
}

$pdo->commit();
echo "Bulk insert of statistics completed!\n";

// 4. Delete old withdrawals
echo "Deleting old withdrawals...\n";
$stmt = $pdo->prepare("DELETE FROM withdraws WHERE user_id = ?");
$stmt->execute([$user_id]);

// 5. Generate withdrawals for July & August
echo "Generating withdrawals...\n";
$withdrawDates = [
    '2026-07-03', '2026-07-06', '2026-07-09', '2026-07-12', '2026-07-15',
    '2026-07-18', '2026-07-21', '2026-07-25', '2026-07-28', '2026-07-31',
    '2026-08-03', '2026-08-06', '2026-08-09'
];

$totalWithdrawn = 0;
foreach ($withdrawDates as $dateStr) {
    $withdrawAmount = rand(50, 100) + (rand(0, 99) / 100);
    $totalWithdrawn += $withdrawAmount;
    
    $created = $dateStr . ' ' . str_pad(rand(9, 18), 2, '0', STR_PAD_LEFT) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT) . ':00';
    
    $stmt = $pdo->prepare("INSERT INTO withdraws (user_id, status, publisher_earnings, referral_earnings, amount, method, account, transaction_id, created) VALUES (?, 3, ?, 0, ?, 'paypal', 'tutulnaj@gmail.com', ?, ?)");
    $stmt->execute([
        $user_id,
        $withdrawAmount,
        $withdrawAmount,
        strtoupper(substr(md5(uniqid()), 0, 12)),
        $created
    ]);
}
echo "Total Withdrawn: $totalWithdrawn\n";

// 6. Update user's wallet and publisher earnings
$totalTargetEarnings = ($totalRows / 1000) * $cpm;
$finalBalance = $totalTargetEarnings - $totalWithdrawn;
if ($finalBalance < 0) {
    $finalBalance = 155.43;
}

$stmt = $pdo->prepare("UPDATE users SET publisher_earnings = ?, wallet_money = ? WHERE id = ?");
$stmt->execute([$finalBalance, $finalBalance, $user_id]);
echo "Updated user publisher_earnings and wallet_money to $finalBalance\n";

echo "All tasks completed successfully!\n";
