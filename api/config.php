<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Gestion des requêtes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Ajustez selon votre config Laragoon
define('DB_PASS', '');     // Ajustez selon votre config Laragoon
define('DB_NAME', 'voteapp');

// Fonction pour obtenir la connexion à la base de données
function getDbConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur de connexion à la base de données']);
        exit();
    }
}

// Fonction pour obtenir un identifiant unique de l'utilisateur
function getUserId() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    // Créer un hash unique basé sur l'IP et le user agent
    return hash('sha256', $ip . $userAgent);
}
?>