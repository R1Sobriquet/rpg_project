<?php
class PersonnageModel {
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
     * Méthode pour insérer un personnage dans la base de données
     * 
     * @param string $nom Nom du personnage
     * @param string $genre Genre du personnage
     * @param int $typeClasseId ID du type de classe
     * @param int $force Force du personnage
     * @param int $agilite Agilité du personnage
     * @param int $intelligence Intelligence du personnage
     * @param int $pointsDeVie Points de vie du personnage
     * @param int $pointsDeMagie Points de magie du personnage
     * @return bool Succès de l'opération
     */
    public function insertPersonnage($nom, $genre, $typeClasseId, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        try {
            $query = "INSERT INTO personnages (nom, genre, type_classe_id, `force`, agilite, intelligence, points_de_vie, points_de_magie) 
                      VALUES (:nom, :genre, :typeClasseId, :force, :agilite, :intelligence, :pointsDeVie, :pointsDeMagie)";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':typeClasseId', $typeClasseId, PDO::PARAM_INT);
            $stmt->bindParam(':force', $force, PDO::PARAM_INT);
            $stmt->bindParam(':agilite', $agilite, PDO::PARAM_INT);
            $stmt->bindParam(':intelligence', $intelligence, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeVie', $pointsDeVie, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeMagie', $pointsDeMagie, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }
    
    /**
     * Méthode pour récupérer tous les personnages avec les informations de leur type de classe
     * 
     * @return array Liste des personnages avec les informations de type de classe
     */
    public function getAllPersonnages() {
        try {
            $query = "SELECT p.*, tc.nom as classe_nom, tc.description as classe_description 
                      FROM personnages p
                      LEFT JOIN type_classe tc ON p.type_classe_id = tc.id
                      ORDER BY p.id DESC";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération : ' . $e->getMessage());
        }
    }
    
    /**
     * Méthode pour récupérer un personnage par son ID avec les informations de son type de classe
     * 
     * @param int $id ID du personnage
     * @return array|bool Données du personnage ou false en cas d'échec
     */
    public function getPersonnageById($id) {
        try {
            $query = "SELECT p.*, tc.nom as classe_nom, tc.description as classe_description 
                      FROM personnages p
                      LEFT JOIN type_classe tc ON p.type_classe_id = tc.id
                      WHERE p.id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération : ' . $e->getMessage());
        }
    }
    
    /**
     * Méthode pour mettre à jour un personnage
     * 
     * @param int $id ID du personnage
     * @param string $nom Nom du personnage
     * @param string $genre Genre du personnage
     * @param int $typeClasseId ID du type de classe
     * @param int $force Force du personnage
     * @param int $agilite Agilité du personnage
     * @param int $intelligence Intelligence du personnage
     * @param int $pointsDeVie Points de vie du personnage
     * @param int $pointsDeMagie Points de magie du personnage
     * @return bool Succès de l'opération
     */
    public function updatePersonnage($id, $nom, $genre, $typeClasseId, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        try {
            $query = "UPDATE personnages 
                      SET nom = :nom, 
                          genre = :genre, 
                          type_classe_id = :typeClasseId, 
                          `force` = :force, 
                          agilite = :agilite, 
                          intelligence = :intelligence, 
                          points_de_vie = :pointsDeVie, 
                          points_de_magie = :pointsDeMagie 
                      WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':typeClasseId', $typeClasseId, PDO::PARAM_INT);
            $stmt->bindParam(':force', $force, PDO::PARAM_INT);
            $stmt->bindParam(':agilite', $agilite, PDO::PARAM_INT);
            $stmt->bindParam(':intelligence', $intelligence, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeVie', $pointsDeVie, PDO::PARAM_INT);
            $stmt->bindParam(':pointsDeMagie', $pointsDeMagie, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    
    /**
     * Méthode pour supprimer un personnage
     * 
     * @param int $id ID du personnage
     * @return bool Succès de l'opération
     */
    public function deletePersonnage($id) {
        try {
            $query = "DELETE FROM personnages WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            die('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
    
    /**
     * Récupère les personnages selon le type de classe
     * 
     * @param int $typeClasseId ID du type de classe
     * @return array Liste des personnages
     */
    public function getPersonnagesByTypeClasse($typeClasseId) {
        try {
            $query = "SELECT p.*, tc.nom as classe_nom
                      FROM personnages p
                      JOIN type_classe tc ON p.type_classe_id = tc.id
                      WHERE p.type_classe_id = :typeClasseId
                      ORDER BY p.nom ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':typeClasseId', $typeClasseId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la récupération des personnages : ' . $e->getMessage());
        }
    }
    
    /**
     * Compte le nombre de personnages par type de classe
     * 
     * @return array Statistiques par type de classe
     */
    public function countPersonnagesByTypeClasse() {
        try {
            $query = "SELECT tc.nom as classe, COUNT(p.id) as total
                      FROM type_classe tc
                      LEFT JOIN personnages p ON tc.id = p.type_classe_id
                      GROUP BY tc.id
                      ORDER BY total DESC";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors du comptage des personnages : ' . $e->getMessage());
        }
    }
    
    /**
     * Recherche de personnages selon différents critères
     * 
     * @param array $criteres Critères de recherche
     * @return array Résultats de la recherche
     */
    public function searchPersonnages($criteres) {
        try {
            $conditions = [];
            $params = [];
            
            if (!empty($criteres['nom'])) {
                $conditions[] = "p.nom LIKE :nom";
                $params[':nom'] = '%' . $criteres['nom'] . '%';
            }
            
            if (!empty($criteres['genre'])) {
                $conditions[] = "p.genre = :genre";
                $params[':genre'] = $criteres['genre'];
            }
            
            if (!empty($criteres['type_classe_id'])) {
                $conditions[] = "p.type_classe_id = :typeClasseId";
                $params[':typeClasseId'] = $criteres['type_classe_id'];
            }
            
            // Construction de la requête
            $query = "SELECT p.*, tc.nom as classe_nom
                      FROM personnages p
                      LEFT JOIN type_classe tc ON p.type_classe_id = tc.id";
            
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $query .= " ORDER BY p.nom ASC";
            
            $stmt = $this->pdo->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur lors de la recherche de personnages : ' . $e->getMessage());
        }
    }
}