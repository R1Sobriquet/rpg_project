<?php
require_once __DIR__ . '/../Entity/Personnage.php';

class Guerrier extends Personnage {
    // Constructeur
    public function __construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        parent::__construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie);
    }
    
    // Implémentation de la méthode abstraite attaquer
    // Surcharge 1: attaque de base avec un seul paramètre
    public function attaquer($cible) {
        echo $this->nom . " attaque " . $cible->getNom() . " avec une épée !\n";
        return $this->force;
    }
    
    // Surcharge 2: attaque avec puissance spécifiée
    public function attaquerAvecPuissance($cible, $puissance) {
        echo $this->nom . " attaque " . $cible->getNom() . " avec une puissance de " . $puissance . " !\n";
        return $this->force * $puissance;
    }
    
    // Surcharge 3: attaque en spécifiant l'arme
    public function attaquerAvecArme($cible, $arme) {
        echo $this->nom . " attaque " . $cible->getNom() . " avec " . $arme . " !\n";
        return $this->force + 5; // Bonus d'arme
    }
}