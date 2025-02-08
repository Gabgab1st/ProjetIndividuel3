<?php
require_once 'config.php'; // Inclure le fichier de configuration

try {
    // Connexion à MySQL avec PDO
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    
    // Définir le mode d'erreur de PDO pour afficher les exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Afficher l'erreur si la connexion échoue
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>
