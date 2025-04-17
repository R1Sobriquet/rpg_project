<?php
require_once __DIR__ . '/../Entity/Personnage.php';
require_once __DIR__ . '/../Interface/Combatant.php';

class Archer extends Personnage implements Combatant {
    public function __construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        parent::__construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie);
    }
    
    // Implémentation de la méthode abstraite attaquer
    public function attaquer($cible) {
        echo $this->nom . " tire une flèche sur " . $cible->getNom() . " !\n";
        return $this->agilite * 1.2; // Les archers utilisent l'agilité pour leurs attaques
    }
    
    // Implémentation de la méthode de l'interface Combatant
    public function combattre($cible) {
        echo $this->nom . " engage le combat contre " . $cible->getNom() . " !\n";
        $this->attaquer($cible);
    }
}