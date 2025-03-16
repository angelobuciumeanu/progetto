<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../lib/Database.php';

$QUERY = "SELECT * FROM prodotti ORDER BY created_at DESC";

try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query($QUERY);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Errore nel recupero dei prodotti: ' . $e->getMessage()]);
}
?>
