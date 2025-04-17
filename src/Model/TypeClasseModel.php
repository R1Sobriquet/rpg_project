<?php
class TypeClasseModel {
    private $pdo;
    
    /**
     * Constructeur - établit la connexion à la base de données
     */
    public function __construct() {
        try {
            // Inclusion du fichier de configuration de la base de données
            require_once __DIR__ . '/../../config/database.php';
            
            // Utilisation de la fonction getConnection du fichier de configuration
            $this->pdo = getConnection();
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
    
    /**
     * Obtenir l'objet PDO pour exécuter des requêtes personnalisées
     * 
     * @return PDO Objet PDO
     */
    public function getPdo() {
        return $this->pdo;
    }
    
    /**
     * Récupérer tous les types de classe
     * 
     * @return array Liste des types de classe
     */
    public function getAllTypeClasses() {
        try {
            $query = "SELECT * FROM type_classe ORDER BY nom";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération des types de classe : ' . $e->getMessage());
        }
    }
    
    /**
     * Récupérer un type de classe par son ID
     * 
     * @param int $id ID du type de classe
     * @return array|bool Données du type de classe ou false en cas d'échec
     */
    public function getTypeClasseById($id) {
        try {
            $query = "SELECT * FROM type_classe WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération du type de classe : ' . $e->getMessage());
        }
    }
    
    /**
     * Ajouter un nouveau type de classe
     * 
     * @param string $nom Nom du type de classe
     * @param string $description Description du type de classe
     * @param int $forceBase Force de base
     * @param int $agiliteBase Agilité de base
     * @param int $intelligenceBase Intelligence de base
     * @param int $pointsDeVieBase Points de vie de base
     * @param int $pointsDeMagieBase Points de magie de base
     * @return bool Succès de l'opération
     */
    public function addTypeClasse($nom, $description, $forceBase, $agiliteBase, $intelligenceBase, $pointsDeVieBase, $pointsDeMagieBase) {
        try {
            $query = "INSERT INTO type_classe (nom, description, force_base, agilite_base, intelligence_base, points_de_vie_base, points_de_magie_base) 
                      VALUES (:nom, :description, :forceBase, :agiliteBase, :intelligenceBase, :pointsDeVieBase, :pointsDeMagieBase)";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':forceBase', $forceBase, PDO::PARAM_INT);
            $stmt->bindParam(':agiliteBase', $agiliteBase, PDO::PARAM_INT);
            $stmt->bindParam(':intelligenceBase', $intelligenceBase, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeVieBase', $pointsDeVieBase, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeMagieBase', $pointsDeMagieBase, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de l\'ajout du type de classe : ' . $e->getMessage());
        }
    }
    
    /**
     * Mettre à jour un type de classe existant
     * 
     * @param int $id ID du type de classe
     * @param string $nom Nom du type de classe
     * @param string $description Description du type de classe
     * @param int $forceBase Force de base
     * @param int $agiliteBase Agilité de base
     * @param int $intelligenceBase Intelligence de base
     * @param int $pointsDeVieBase Points de vie de base
     * @param int $pointsDeMagieBase Points de magie de base
     * @return bool Succès de l'opération
     */
    public function updateTypeClasse($id, $nom, $description, $forceBase, $agiliteBase, $intelligenceBase, $pointsDeVieBase, $pointsDeMagieBase) {
        try {
            $query = "UPDATE type_classe SET 
                      nom = :nom, 
                      description = :description, 
                      force_base = :forceBase, 
                      agilite_base = :agiliteBase, 
                      intelligence_base = :intelligenceBase, 
                      points_de_vie_base = :pointsDeVieBase, 
                      points_de_magie_base = :pointsDeMagieBase
                      WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':forceBase', $forceBase, PDO::PARAM_INT);
            $stmt->bindParam(':agiliteBase', $agiliteBase, PDO::PARAM_INT);
            $stmt->bindParam(':intelligenceBase', $intelligenceBase, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeVieBase', $pointsDeVieBase, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeMagieBase', $pointsDeMagieBase, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de la mise à jour du type de classe : ' . $e->getMessage());
        }
    }
    
    /**
     * Supprimer un type de classe
     * 
     * @param int $id ID du type de classe
     * @return bool Succès de l'opération
     */
    public function deleteTypeClasse($id) {
        try {
            // D'abord, vérifier s'il y a des personnages qui utilisent ce type de classe
            $checkQuery = "SELECT COUNT(*) FROM personnages WHERE type_classe_id = :id";
            $checkStmt = $this->pdo->prepare($checkQuery);
            $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $checkStmt->execute();
            
            if ($checkStmt->fetchColumn() > 0) {
                // Si des personnages utilisent ce type, on ne peut pas le supprimer
                return false;
            }
            
            // Sinon, procéder à la suppression
            $query = "DELETE FROM type_classe WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de la suppression du type de classe : ' . $e->getMessage());
        }
    }
    
    /**
     * Récupérer le type de classe par son nom
     * 
     * @param string $nom Nom du type de classe
     * @return array|bool Données du type de classe ou false
     */
    public function getTypeClasseByNom($nom) {
        try {
            $query = "SELECT * FROM type_classe WHERE nom = :nom";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération du type de classe : ' . $e->getMessage());
        }
    }
}