<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT id, alias, url, title, description FROM links WHERE alias LIKE '%Paul%' OR title LIKE '%Paul%' OR description LIKE '%Paul%'");
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($links as $link) {
    echo "Link ID: " . $link['id'] . " - Alias: " . $link['alias'] . " - Title: " . $link['title'] . " - Desc: " . $link['description'] . "\n";
}
echo "Search completed.\n";
