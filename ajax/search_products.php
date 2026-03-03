<?php
// Load Config and DB
require_once '../config/config.php';
require_once '../config/db.php';

header('Content-Type: application/json');

if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    echo json_encode([]);
    exit;
}

$searchTerm = trim($_GET['q']);
$query = "%" . $searchTerm . "%";

try {
    $stmt = $pdo->prepare("
        SELECT p.id, p.name, p.slug, p.price, p.image 
        FROM products p 
        WHERE p.name LIKE :query OR p.description LIKE :query
        LIMIT 10
    ");
    $stmt->execute(['query' => $query]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error']);
}
?>