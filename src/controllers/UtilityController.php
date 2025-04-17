<?php 
require_once 'src/controllers/PersonnageController.php';
require_once 'src/controllers/GuerrierController.php';
require_once 'src/controllers/MageController.php';

class UtilityController {
    public static function afficherPersonnage($personnage) {
        echo "Nom: " . $personnage->getNom() . "\n";
        echo "Genre: " . $personnage->getGenre() . "\n";
        echo "Classe: " . $personnage->getClasse() . "\n";
        echo "Force: " . $personnage->getForce() . "\n";
        echo "Agilité: " . $personnage->getAgilite() . "\n";
        echo "Intelligence: " . $personnage->getIntelligence() . "\n";
        echo "Points de Vie: " . $personnage->getPointsDeVie() . "\n";
        echo "Points de Magie: " . $personnage->getPointsDeMagie() . "\n";
    }
}