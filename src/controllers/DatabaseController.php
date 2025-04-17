<?php
class DatabaseController {
    private $pdo;
    
    // Constructeur - établit la connexion à la base de données
    public function __construct() {
        try {
            // Inclusion du fichier de configuration de la base de données
            require_once 'config/database.php';
            
            // Utilisation de la fonction getConnection du fichier de configuration
            $this->pdo = getConnection();
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
    
    /**
     * Obtenir l'objet PDO pour exécuter des requêtes personnalisées
     * @return PDO Objet PDO
     */
    public function getPdo() {
        return $this->pdo;
    }
    
    // Méthode pour insérer un personnage dans la base de données
    public function insertPersonnage($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        try {
            $query = "INSERT INTO personnages (nom, genre, classe, force, agilite, intelligence, points_de_vie, points_de_magie) 
                      VALUES (:nom, :genre, :classe, :force, :agilite, :intelligence, :pointsDeVie, :pointsDeMagie)";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':classe', $classe);
            $stmt->bindParam(':force', $force);
            $stmt->bindParam(':agilite', $agilite);
            $stmt->bindParam(':intelligence', $intelligence);
            $stmt->bindParam(':pointsDeVie', $pointsDeVie);
            $stmt->bindParam(':pointsDeMagie', $pointsDeMagie);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }
    
    // Méthode pour récupérer tous les personnages
    public function getAllPersonnages() {
        try {
            $query = "SELECT * FROM personnages";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération : ' . $e->getMessage());
        }
    }
    
    // Méthode pour récupérer un personnage par son ID
    public function getPersonnageById($id) {
        try {
            $query = "SELECT * FROM personnages WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération : ' . $e->getMessage());
        }
    }
    
    // Méthode pour mettre à jour un personnage
    public function updatePersonnage($id, $nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        try {
            $query = "UPDATE personnages 
                      SET nom = :nom, genre = :genre, classe = :classe, force = :force, 
                          agilite = :agilite, intelligence = :intelligence, 
                          points_de_vie = :pointsDeVie, points_de_magie = :pointsDeMagie 
                      WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':classe', $classe);
            $stmt->bindParam(':force', $force);
            $stmt->bindParam(':agilite', $agilite);
            $stmt->bindParam(':intelligence', $intelligence);
            $stmt->bindParam(':pointsDeVie', $pointsDeVie);
            $stmt->bindParam(':pointsDeMagie', $pointsDeMagie);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    
    // Méthode pour supprimer un personnage
    public function deletePersonnage($id) {
        try {
            $query = "DELETE FROM personnages WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}