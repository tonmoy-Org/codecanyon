<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$campaign_id = 6;
$targetPrice = 100000.00;
$targetPurchase = 1000; // 1000 * 1000 = 1,000,000 views
$targetViews = 1000000; // 10 lakh views

// 1. Update Campaigns table
$stmt = $pdo->prepare("UPDATE campaigns SET price = ? WHERE id = ?");
$stmt->execute([$targetPrice, $campaign_id]);
echo "Updated campaigns table price to $targetPrice.\n";

// 2. Delete existing campaign items for ID 6
$stmt = $pdo->prepare("DELETE FROM campaign_items WHERE campaign_id = ?");
$stmt->execute([$campaign_id]);
echo "Deleted old campaign items for campaign 6.\n";

// 3. Insert new campaign item
$stmt = $pdo->prepare("INSERT INTO campaign_items (campaign_id, country, advertiser_price, publisher_price, purchase, views, weight) VALUES (?, 'all', 10.000000000, 4.000000000, ?, ?, 0)");
$stmt->execute([$campaign_id, $targetPurchase, $targetViews]);
echo "Inserted campaign item: purchase = $targetPurchase, views = $targetViews.\n";

echo "Done updating campaign 6!\n";
