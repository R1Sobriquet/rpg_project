<?php
/**
 * Script AJAX pour récupérer les statistiques d'un type de classe
 */

// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../src/Controller/PersonnageController.php';

// Vérification de la méthode de requête
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

// Vérification du paramètre id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'ID de classe invalide']);
    exit;
}

$typeClasseId = (int)$_GET['id'];

// Création du contrôleur
$controller = new PersonnageController();

// Récupération des valeurs par défaut
$valeursParDefaut = $controller->getValeursParDefaut($typeClasseId);

// Définition du header pour indiquer que la réponse est au format JSON
header('Content-Type: application/json');

// Renvoi des valeurs
echo json_encode($valeursParDefaut);