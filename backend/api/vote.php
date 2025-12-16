<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit();
}

// Récupérer les données JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['vote']) || ($data['vote'] !== 0 && $data['vote'] !== 1)) {
    http_response_code(400);
    echo json_encode(['error' => 'Vote invalide']);
    exit();
}

$vote = (int)$data['vote'];
$userId = getUserId();

try {
    $pdo = getDbConnection();
    
    // Vérifier si l'utilisateur a déjà voté
    $stmt = $pdo->prepare('SELECT id FROM vote WHERE id = ?');
    $stmt->execute([$userId]);
    
    if ($stmt->fetch()) {
        http_response_code(403);
        echo json_encode(['error' => 'Vous avez déjà voté']);
        exit();
    }
    
    // Enregistrer le vote
    $stmt = $pdo->prepare('INSERT INTO vote (id, vote) VALUES (?, ?)');
    $stmt->execute([$userId, $vote]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Vote enregistré avec succès'
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'enregistrement du vote']);
}
?>