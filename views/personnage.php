<?php
class Personnage {
    // Attributs de base
    protected $id;
    protected $nom;
    protected $genre;
    protected $classe;
    protected $force;
    protected $agilite;
    protected $intelligence;
    protected $pointsDeVie;
    protected $pointsDeMagie;
    protected $utilisateurId; // ID de l'utilisateur propriétaire

    /**
     * Constructeur de la classe Personnage
     * 
     * @param string $nom Nom du personnage
     * @param string $genre Genre du personnage
     * @param string $classe Classe du personnage
     * @param int $force Force du personnage
     * @param int $agilite Agilité du personnage
     * @param int $intelligence Intelligence du personnage
     * @param int $pointsDeVie Points de vie du personnage
     * @param int $pointsDeMagie Points de magie du personnage
     * @param int $utilisateurId ID de l'utilisateur propriétaire (optionnel)
     */
    public function __construct($nom = "", $genre = "", $classe = "", $force = 0, $agilite = 0, $intelligence = 0, $pointsDeVie = 0, $pointsDeMagie = 0, $utilisateurId = null) {
        $this->nom = $nom;
        $this->genre = $genre;
        $this->classe = $classe;
        $this->force = $force;
        $this->agilite = $agilite;
        $this->intelligence = $intelligence;
        $this->pointsDeVie = $pointsDeVie;
        $this->pointsDeMagie = $pointsDeMagie;
        $this->utilisateurId = $utilisateurId;
    }

    /**
     * Obtenir l'ID du personnage
     * 
     * @return int ID du personnage
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Définir l'ID du personnage
     * 
     * @param int $id Nouvel ID du personnage
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Obtenir le nom du personnage
     * 
     * @return string Nom du personnage
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Définir le nom du personnage
     * 
     * @param string $nom Nouveau nom du personnage
     */
    public function setNom($nom) {
        $this->nom = $nom;
    }

    /**
     * Obtenir le genre du personnage
     * 
     * @return string Genre du personnage
     */
    public function getGenre() {
        return $this->genre;
    }

    /**
     * Définir le genre du personnage
     * 
     * @param string $genre Nouveau genre du personnage
     */
    public function setGenre($genre) {
        $this->genre = $genre;
    }

    /**
     * Obtenir la classe du personnage
     * 
     * @return string Classe du personnage
     */
    public function getClasse() {
        return $this->classe;
    }

    /**
     * Définir la classe du personnage
     * 
     * @param string $classe Nouvelle classe du personnage
     */
    public function setClasse($classe) {
        $this->classe = $classe;
    }

    /**
     * Obtenir la force du personnage
     * 
     * @return int Force du personnage
     */
    public function getForce() {
        return $this->force;
    }

    /**
     * Définir la force du personnage
     * 
     * @param int $force Nouvelle force du personnage
     */
    public function setForce($force) {
        $this->force = $force;
    }

    /**
     * Obtenir l'agilité du personnage
     * 
     * @return int Agilité du personnage
     */
    public function getAgilite() {
        return $this->agilite;
    }

    /**
     * Définir l'agilité du personnage
     * 
     * @param int $agilite Nouvelle agilité du personnage
     */
    public function setAgilite($agilite) {
        $this->agilite = $agilite;
    }

    /**
     * Obtenir l'intelligence du personnage
     * 
     * @return int Intelligence du personnage
     */
    public function getIntelligence() {
        return $this->intelligence;
    }

    /**
     * Définir l'intelligence du personnage
     * 
     * @param int $intelligence Nouvelle intelligence du personnage
     */
    public function setIntelligence($intelligence) {
        $this->intelligence = $intelligence;
    }

    /**
     * Obtenir les points de vie du personnage
     * 
     * @return int Points de vie du personnage
     */
    public function getPointsDeVie() {
        return $this->pointsDeVie;
    }

    /**
     * Définir les points de vie du personnage
     * 
     * @param int $pointsDeVie Nouveaux points de vie du personnage
     */
    public function setPointsDeVie($pointsDeVie) {
        $this->pointsDeVie = $pointsDeVie;
    }

    /**
     * Obtenir les points de magie du personnage
     * 
     * @return int Points de magie du personnage
     */
    public function getPointsDeMagie() {
        return $this->pointsDeMagie;
    }

    /**
     * Définir les points de magie du personnage
     * 
     * @param int $pointsDeMagie Nouveaux points de magie du personnage
     */
    public function setPointsDeMagie($pointsDeMagie) {
        $this->pointsDeMagie = $pointsDeMagie;
    }

    /**
     * Obtenir l'ID de l'utilisateur propriétaire du personnage
     * 
     * @return int ID de l'utilisateur propriétaire
     */
    public function getUtilisateurId() {
        return $this->utilisateurId;
    }

    /**
     * Définir l'ID de l'utilisateur propriétaire du personnage
     * 
     * @param int $utilisateurId Nouvel ID de l'utilisateur propriétaire
     */
    public function setUtilisateurId($utilisateurId) {
        $this->utilisateurId = $utilisateurId;
    }

    /**
     * Sauvegarder le personnage dans la base de données
     * 
     * @param DatabaseController $db Contrôleur de base de données
     * @return bool Succès de l'opération
     */
    public function sauvegarder($db) {
        // Si le personnage existe déjà, mise à jour
        if ($this->id) {
            try {
                $query = "UPDATE personnages SET 
                            nom = :nom, 
                            genre = :genre, 
                            classe = :classe, 
                            `force` = :force, 
                            agilite = :agilite, 
                            intelligence = :intelligence, 
                            points_de_vie = :pointsDeVie, 
                            points_de_magie = :pointsDeMagie,
                            utilisateur_id = :utilisateurId
                          WHERE id = :id";
                
                $stmt = $db->getPdo()->prepare($query);
                
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':nom', $this->nom);
                $stmt->bindParam(':genre', $this->genre);
                $stmt->bindParam(':classe', $this->classe);
                $stmt->bindParam(':force', $this->force);
                $stmt->bindParam(':agilite', $this->agilite);
                $stmt->bindParam(':intelligence', $this->intelligence);
                $stmt->bindParam(':pointsDeVie', $this->pointsDeVie);
                $stmt->bindParam(':pointsDeMagie', $this->pointsDeMagie);
                $stmt->bindParam(':utilisateurId', $this->utilisateurId);
                
                return $stmt->execute();
            } catch (PDOException $e) {
                // En cas d'erreur, afficher un message et retourner false
                echo "Erreur lors de la mise à jour du personnage : " . $e->getMessage();
                return false;
            }
        } 
        // Sinon, création d'un nouveau personnage
        else {
            try {
                $query = "INSERT INTO personnages (nom, genre, classe, `force`, agilite, intelligence, points_de_vie, points_de_magie, utilisateur_id) 
                          VALUES (:nom, :genre, :classe, :force, :agilite, :intelligence, :pointsDeVie, :pointsDeMagie, :utilisateurId)";
                
                $stmt = $db->getPdo()->prepare($query);
                
                $stmt->bindParam(':nom', $this->nom);
                $stmt->bindParam(':genre', $this->genre);
                $stmt->bindParam(':classe', $this->classe);
                $stmt->bindParam(':force', $this->force);
                $stmt->bindParam(':agilite', $this->agilite);
                $stmt->bindParam(':intelligence', $this->intelligence);
                $stmt->bindParam(':pointsDeVie', $this->pointsDeVie);
                $stmt->bindParam(':pointsDeMagie', $this->pointsDeMagie);
                $stmt->bindParam(':utilisateurId', $this->utilisateurId);
                
                $result = $stmt->execute();
                
                if ($result) {
                    $this->id = $db->getPdo()->lastInsertId();
                }
                
                return $result;
            } catch (PDOException $e) {
                // En cas d'erreur, afficher un message et retourner false
                echo "Erreur lors de la création du personnage : " . $e->getMessage();
                return false;
            }
        }
    }

    /**
     * Charger un personnage depuis la base de données
     * 
     * @param DatabaseController $db Contrôleur de base de données
     * @param int $id ID du personnage à charger
     * @return Personnage|null Le personnage chargé ou null en cas d'échec
     */
    public static function charger($db, $id) {
        try {
            $query = "SELECT * FROM personnages WHERE id = :id";
            $stmt = $db->getPdo()->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                $personnage = new Personnage();
                $personnage->setId($data['id']);
                $personnage->setNom($data['nom']);
                $personnage->setGenre($data['genre']);
                $personnage->setClasse($data['classe']);
                $personnage->setForce($data['force']);
                $personnage->setAgilite($data['agilite']);
                $personnage->setIntelligence($data['intelligence']);
                $personnage->setPointsDeVie($data['points_de_vie']);
                $personnage->setPointsDeMagie($data['points_de_magie']);
                $personnage->setUtilisateurId($data['utilisateur_id']);
                
                return $personnage;
            }
            
            return null;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message et retourner null
            echo "Erreur lors du chargement du personnage : " . $e->getMessage();
            return null;
        }
    }

    /**
     * Charger tous les personnages d'un utilisateur
     * 
     * @param DatabaseController $db Contrôleur de base de données
     * @param int $utilisateurId ID de l'utilisateur
     * @return array Liste des personnages de l'utilisateur
     */
    public static function chargerParUtilisateur($db, $utilisateurId) {
        try {
            $query = "SELECT * FROM personnages WHERE utilisateur_id = :utilisateurId";
            $stmt = $db->getPdo()->prepare($query);
            $stmt->bindParam(':utilisateurId', $utilisateurId);
            $stmt->execute();
            
            $personnages = [];
            
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $personnage = new Personnage();
                $personnage->setId($data['id']);
                $personnage->setNom($data['nom']);
                $personnage->setGenre($data['genre']);
                $personnage->setClasse($data['classe']);
                $personnage->setForce($data['force']);
                $personnage->setAgilite($data['agilite']);
                $personnage->setIntelligence($data['intelligence']);
                $personnage->setPointsDeVie($data['points_de_vie']);
                $personnage->setPointsDeMagie($data['points_de_magie']);
                $personnage->setUtilisateurId($data['utilisateur_id']);
                
                $personnages[] = $personnage;
            }
            
            return $personnages;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message et retourner un tableau vide
            echo "Erreur lors du chargement des personnages : " . $e->getMessage();
            return [];
        }
    }

    /**
     * Supprimer un personnage de la base de données
     * 
     * @param DatabaseController $db Contrôleur de base de données
     * @return bool Succès de l'opération
     */
    public function supprimer($db) {
        if (!$this->id) {
            return false;
        }
        
        try {
            $query = "DELETE FROM personnages WHERE id = :id";
            $stmt = $db->getPdo()->prepare($query);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message et retourner false
            echo "Erreur lors de la suppression du personnage : " . $e->getMessage();
            return false;
        }
    }
}