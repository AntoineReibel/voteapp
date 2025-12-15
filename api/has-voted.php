<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit();
}

$userId = getUserId();

try {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare('SELECT id FROM vote WHERE id = ?');
    $stmt->execute([$userId]);
    
    $hasVoted = $stmt->fetch() !== false;
    
    echo json_encode(['hasVoted' => $hasVoted]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la vérification']);
}
?>