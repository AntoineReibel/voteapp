<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit();
}

try {
    $pdo = getDbConnection();
    
    // Compter les votes
    $stmt = $pdo->query('SELECT vote, COUNT(*) as count FROM vote GROUP BY vote');
    $results = $stmt->fetchAll();
    
    $oui = 0;
    $non = 0;
    
    foreach ($results as $result) {
        if ($result['vote'] == 1) {
            $oui = (int)$result['count'];
        } else {
            $non = (int)$result['count'];
        }
    }
    
    echo json_encode([
        'oui' => $oui,
        'non' => $non,
        'total' => $oui + $non
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des résultats']);
}
?>