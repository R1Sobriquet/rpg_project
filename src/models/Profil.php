<?php
class Profil {
    private $id;
    private $personnageId;
    private $niveau;
    private $experience;
    private $competences = []; // Liste des compétences débloquées
    private $equipements = []; // Liste des équipements possédés
    
    /**
     * Constructeur de la classe Profil
     * @param int $personnageId Identifiant du personnage associé
     * @param int $niveau Niveau actuel du personnage
     * @param int $experience Points d'expérience actuels
     */
    public function __construct($personnageId = null, $niveau = 1, $experience = 0) {
        $this->personnageId = $personnageId;
        $this->niveau = $niveau;
        $this->experience = $experience;
    }
    
    /**
     * Obtenir l'identifiant du profil
     * @return int Identifiant du profil
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Définir l'identifiant du profil
     * @param int $id Nouvel identifiant
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Obtenir l'identifiant du personnage associé
     * @return int Identifiant du personnage
     */
    public function getPersonnageId() {
        return $this->personnageId;
    }
    
    /**
     * Définir l'identifiant du personnage associé
     * @param int $personnageId Nouvel identifiant du personnage
     */
    public function setPersonnageId($personnageId) {
        $this->personnageId = $personnageId;
    }
    
    /**
     * Obtenir le niveau actuel
     * @return int Niveau actuel
     */
    public function getNiveau() {
        return $this->niveau;
    }
    
    /**
     * Définir le niveau actuel
     * @param int $niveau Nouveau niveau
     */
    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }
    
    /**
     * Obtenir les points d'expérience actuels
     * @return int Points d'expérience
     */
    public function getExperience() {
        return $this->experience;
    }
    
    /**
     * Définir les points d'expérience
     * @param int $experience Nouveaux points d'expérience
     */
    public function setExperience($experience) {
        $this->experience = $experience;
    }
    
    /**
     * Obtenir les compétences débloquées
     * @return array Liste des compétences
     */
    public function getCompetences() {
        return $this->competences;
    }
    
    /**
     * Ajouter une compétence
     * @param string $competence Nouvelle compétence
     */
    public function ajouterCompetence($competence) {
        if (!in_array($competence, $this->competences)) {
            $this->competences[] = $competence;
            return true;
        }
        return false;
    }
    
    /**
     * Obtenir les équipements possédés
     * @return array Liste des équipements
     */
    public function getEquipements() {
        return $this->equipements;
    }
    
    /**
     * Ajouter un équipement
     * @param string $equipement Nouvel équipement
     */
    public function ajouterEquipement($equipement) {
        if (!in_array($equipement, $this->equipements)) {
            $this->equipements[] = $equipement;
            return true;
        }
        return false;
    }
    
    /**
     * Gagner de l'expérience et monter de niveau si nécessaire
     * @param int $experience Points d'expérience gagnés
     * @return bool True si le personnage a monté de niveau
     */
    public function gagnerExperience($experience) {
        $this->experience += $experience;
        
        // Calcul de l'expérience nécessaire pour le niveau suivant
        $experienceRequise = $this->calculerExperienceRequise();
        
        // Vérifier si le personnage monte de niveau
        if ($this->experience >= $experienceRequise) {
            $this->niveau++;
            return true;
        }
        
        return false;
    }
    
    /**
     * Calculer l'expérience requise pour le prochain niveau
     * @return int Points d'expérience requis
     */
    private function calculerExperienceRequise() {
        // Formule simple pour calculer l'expérience requise
        // Niveau actuel * 100 + (Niveau actuel^2 * 50)
        return ($this->niveau * 100) + (pow($this->niveau, 2) * 50);
    }
    
    /**
     * Calculer le pourcentage d'expérience jusqu'au prochain niveau
     * @return float Pourcentage d'expérience (0-100)
     */
    public function calculerPourcentageExperience() {
        $experienceRequise = $this->calculerExperienceRequise();
        $experiencePrecedente = ($this->niveau - 1) * 100 + (pow($this->niveau - 1, 2) * 50);
        
        $experienceNiveau = $experienceRequise - $experiencePrecedente;
        $experienceActuelle = $this->experience - $experiencePrecedente;
        
        return min(100, max(0, ($experienceActuelle / $experienceNiveau) * 100));
    }
    
    /**
     * Sauvegarder le profil dans la base de données
     * @param DatabaseController $db Contrôleur de base de données
     * @return bool Succès de l'opération
     */
    public function sauvegarder($db) {
        // Implémentation de la sauvegarde
        // À adapter selon votre structure de base de données
        return true;
    }
}