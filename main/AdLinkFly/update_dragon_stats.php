<?php

$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$user_id = 21;
$targetViews = 360685;
$targetBalance = 946.25800;
$targetWallet = 590.00;

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

// 3. Insert views (exactly 360,685 views)
$batchSize = 2500;
$publisher_earn_per_view = $targetBalance / $targetViews; // ~0.0026235025

echo "Inserting $targetViews views in batches of $batchSize...\n";

// Dates range: July 1 to August 11, 2026
$startDate = strtotime('2026-07-01');
$endDate = strtotime('2026-08-11');

$pdo->beginTransaction();

for ($inserted = 0; $inserted < $targetViews; $inserted += $batchSize) {
    $currentBatchSize = min($batchSize, $targetViews - $inserted);
    
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

// 4. Update user's wallet and publisher earnings
$stmt = $pdo->prepare("UPDATE users SET publisher_earnings = ?, wallet_money = ? WHERE id = ?");
$stmt->execute([$targetBalance, $targetWallet, $user_id]);
echo "Updated user publisher_earnings to $targetBalance and wallet_money to $targetWallet\n";

echo "Done adjusting stats for dragonlinkads.com!\n";
