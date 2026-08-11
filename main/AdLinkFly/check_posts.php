<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=adlinkfly;charset=utf8", "adlinkfly_user", "AdlinkPass2024", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT id, title, description FROM posts");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($posts as $post) {
    if (stripos($post['title'], 'Paul') !== false || stripos($post['description'], 'Paul') !== false) {
        echo "Found in POST ID: " . $post['id'] . " - Title: " . $post['title'] . "\n";
    }
}

$stmt = $pdo->query("SELECT id, title, content FROM pages");
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($pages as $page) {
    if (stripos($page['title'], 'Paul') !== false || stripos($page['content'], 'Paul') !== false) {
        echo "Found in PAGE ID: " . $page['id'] . " - Title: " . $page['title'] . "\n";
    }
}

echo "Search completed.\n";
