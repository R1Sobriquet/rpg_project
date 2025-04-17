<?php
require_once __DIR__ . '/../Entity/Personnage.php';

class Mage extends Personnage {
    // Constructeur
    public function __construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        parent::__construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie);
    }
    
    // Implémentation de la méthode abstraite attaquer avec comportement spécifique au Mage
    public function attaquer($cible) {
        echo $this->nom . " lance un sort sur " . $cible->getNom() . " !\n";
        return $this->intelligence * 1.5; // Les mages utilisent l'intelligence pour leurs attaques
    }
}