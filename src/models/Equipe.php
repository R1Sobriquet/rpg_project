<?php
class Equipe {
    private $id;
    private $nom;
    private $description;
    private $membres = []; // Liste des personnages dans l'équipe
    
    /**
     * Constructeur de la classe Equipe
     * @param string $nom Nom de l'équipe
     * @param string $description Description de l'équipe
     */
    public function __construct($nom = "", $description = "") {
        $this->nom = $nom;
        $this->description = $description;
    }
    
    /**
     * Obtenir l'identifiant de l'équipe
     * @return int Identifiant de l'équipe
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Définir l'identifiant de l'équipe
     * @param int $id Nouvel identifiant
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Obtenir le nom de l'équipe
     * @return string Nom de l'équipe
     */
    public function getNom() {
        return $this->nom;
    }
    
    /**
     * Définir le nom de l'équipe
     * @param string $nom Nouveau nom
     */
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    /**
     * Obtenir la description de l'équipe
     * @return string Description de l'équipe
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * Définir la description de l'équipe
     * @param string $description Nouvelle description
     */
    public function setDescription($description) {
        $this->description = $description;
    }
    
    /**
     * Obtenir les membres de l'équipe
     * @return array Liste des personnages dans l'équipe
     */
    public function getMembres() {
        return $this->membres;
    }
    
    /**
     * Ajouter un personnage à l'équipe
     * @param Personnage $personnage Personnage à ajouter
     * @return bool Succès de l'opération
     */
    public function ajouterMembre($personnage) {
        // Vérifier si le personnage n'est pas déjà dans l'équipe
        foreach ($this->membres as $membre) {
            if ($membre->getId() === $personnage->getId()) {
                return false; // Le personnage est déjà dans l'équipe
            }
        }
        
        // Ajouter le personnage à l'équipe
        $this->membres[] = $personnage;
        return true;
    }
    
    /**
     * Retirer un personnage de l'équipe
     * @param int $personnageId Identifiant du personnage à retirer
     * @return bool Succès de l'opération
     */
    public function retirerMembre($personnageId) {
        foreach ($this->membres as $key => $membre) {
            if ($membre->getId() === $personnageId) {
                unset($this->membres[$key]);
                $this->membres = array_values($this->membres); // Réindexer le tableau
                return true;
            }
        }
        
        return false; // Personnage non trouvé dans l'équipe
    }
    
    /**
     * Calculer la puissance totale de l'équipe
     * @return int Puissance totale
     */
    public function calculerPuissanceTotale() {
        $puissance = 0;
        
        foreach ($this->membres as $membre) {
            // Somme des caractéristiques principales du personnage
            $puissance += $membre->getForce() + $membre->getAgilite() + $membre->getIntelligence();
        }
        
        return $puissance;
    }
    
    /**
     * Sauvegarder l'équipe dans la base de données
     * @param DatabaseController $db Contrôleur de base de données
     * @return bool Succès de l'opération
     */
    public function sauvegarder($db) {
        // Implémentation de la sauvegarde
        // À adapter selon votre structure de base de données
        return true;
    }
}