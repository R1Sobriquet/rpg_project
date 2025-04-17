<?php
/**
 * Configuration de la connexion à la base de données
 * 
 * Ce fichier contient les paramètres nécessaires pour établir
 * une connexion à la base de données du système RPG.
 */

// Paramètres de connexion à la base de données
define('DB_HOST', 'localhost');         // Hôte de la base de données
define('DB_NAME', 'rpg_database');      // Nom de la base de données
define('DB_USER', 'root');              // Nom d'utilisateur
define('DB_PASS', '');                  // Mot de passe (vide par défaut pour XAMPP/WAMP)
define('DB_CHARSET', 'utf8mb4');        // Jeu de caractères

// Options PDO pour la connexion
define('DB_OPTIONS', [
    // Activer les exceptions PDO pour la gestion des erreurs
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    
    // Mode de récupération par défaut : tableau associatif
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Émuler les requêtes préparées (utile pour certains serveurs MySQL)
    PDO::ATTR_EMULATE_PREPARES => false,
    
    // Convertir les valeurs numériques en type PHP correspondant
    PDO::ATTR_STRINGIFY_FETCHES => false
]);

/**
 * Fonction pour établir une connexion à la base de données
 * 
 * @return PDO Instance de connexion PDO
 * @throws PDOException En cas d'erreur de connexion
 */
function getConnection() {
    try {
        // Création de la chaîne DSN (Data Source Name)
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        
        // Création et retour de l'objet PDO
        return new PDO($dsn, DB_USER, DB_PASS, DB_OPTIONS);
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message et arrêter le script
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}