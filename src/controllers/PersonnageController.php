<?php abstract class Personnage {
    // Attributs protégés
    protected $nom;
    protected $genre;
    protected $classe;
    protected $force;
    protected $agilite;
    protected $intelligence;
    protected $pointsDeVie;
    protected $pointsDeMagie;
    
    // Constructeur
    public function __construct($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        $this->nom = $nom;
        $this->genre = $genre;
        $this->classe = $classe;
        $this->force = $force;
        $this->agilite = $agilite;
        $this->intelligence = $intelligence;
        $this->pointsDeVie = $pointsDeVie;
        $this->pointsDeMagie = $pointsDeMagie;
    }
    
    // Méthodes getters
    public function getNom() {
        return $this->nom;
    }
    
    public function getGenre() {
        return $this->genre;
    }
    
    public function getClasse() {
        return $this->classe;
    }
    
    public function getForce() {
        return $this->force;
    }
    
    public function getAgilite() {
        return $this->agilite;
    }
    
    public function getIntelligence() {
        return $this->intelligence;
    }
    
    public function getPointsDeVie() {
        return $this->pointsDeVie;
    }
    
    public function getPointsDeMagie() {
        return $this->pointsDeMagie;
    }
    
    // Méthode abstraite à implémenter dans les classes enfants
    abstract public function attaquer($cible);
}