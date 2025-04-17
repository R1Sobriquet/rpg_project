<?php
class Utilisateur {
    private $id;
    private $username;
    private $email;
    private $password;
    private $dateInscription;
    private $dernierLogin;
    private $personnages = []; // Liste des personnages créés par l'utilisateur
    
    /**
     * Constructeur de la classe Utilisateur
     * @param string $username Nom d'utilisateur
     * @param string $email Adresse email
     * @param string $password Mot de passe (déjà hashé)
     */
    public function __construct($username = "", $email = "", $password = "") {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->dateInscription = date('Y-m-d H:i:s');
        $this->dernierLogin = date('Y-m-d H:i:s');
    }
    
    /**
     * Obtenir l'identifiant de l'utilisateur
     * @return int Identifiant
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Définir l'identifiant de l'utilisateur
     * @param int $id Nouvel identifiant
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Obtenir le nom d'utilisateur
     * @return string Nom d'utilisateur
     */
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * Définir le nom d'utilisateur
     * @param string $username Nouveau nom d'utilisateur
     */
    public function setUsername($username) {
        $this->username = $username;
    }
    
    /**
     * Obtenir l'adresse email
     * @return string Adresse email
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * Définir l'adresse email
     * @param string $email Nouvelle adresse email
     */
    public function setEmail($email) {
        $this->email = $email;
    }
    
    /**
     * Vérifier si le mot de passe est correct
     * @param string $password Mot de passe à vérifier
     * @return bool Résultat de la vérification
     */
    public function verifierPassword($password) {
        // Vérification avec password_verify si le mot de passe est hashé
        if (password_get_info($this->password)['algo']) {
            return password_verify($password, $this->password);
        }
        
        // Sinon, comparaison directe (non recommandé en production)
        return $this->password === $password;
    }
    
    /**
     * Définir un nouveau mot de passe
     * @param string $password Nouveau mot de passe
     * @param bool $hasher Hasher ou non le mot de passe
     */
    public function setPassword($password, $hasher = true) {
        if ($hasher) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->password = $password;
        }
    }
    
    /**
     * Obtenir la date d'inscription
     * @return string Date d'inscription
     */
    public function getDateInscription() {
        return $this->dateInscription;
    }
    
    /**
     * Obtenir la date du dernier login
     * @return string Date du dernier login
     */
    public function getDernierLogin() {
        return $this->dernierLogin;
    }
    
    /**
     * Mettre à jour la date du dernier login
     */
    public function mettreAJourLogin() {
        $this->dernierLogin = date('Y-m-d H:i:s');
    }
    
    /**
     * Obtenir les personnages de l'utilisateur
     * @return array Liste des personnages
     */
    public function getPersonnages() {
        return $this->personnages;
    }
    
    /**
     * Ajouter un personnage à l'utilisateur
     * @param Personnage $personnage Personnage à ajouter
     */
    public function ajouterPersonnage($personnage) {
        $this->personnages[] = $personnage;
    }
    
    /**
     * Supprimer un personnage
     * @param int $personnageId Identifiant du personnage à supprimer
     * @return bool Succès de l'opération
     */
    public function supprimerPersonnage($personnageId) {
        foreach ($this->personnages as $key => $personnage) {
            if ($personnage->getId() === $personnageId) {
                unset($this->personnages[$key]);
                $this->personnages = array_values($this->personnages); // Réindexer le tableau
                return true;
            }
        }
        
        return false; // Personnage non trouvé
    }
    
    /**
     * Sauvegarder l'utilisateur dans la base de données
     * @param DatabaseController $db Contrôleur de base de données
     * @return bool Succès de l'opération
     */
    public function sauvegarder($db) {
        // Si l'utilisateur existe déjà, mise à jour
        if ($this->id) {
            try {
                $query = "UPDATE utilisateurs SET 
                            username = :username, 
                            email = :email, 
                            password = :password, 
                            dernier_login = :dernierLogin 
                          WHERE id = :id";
                
                $stmt = $db->getPdo()->prepare($query);
                
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':password', $this->password);
                $stmt->bindParam(':dernierLogin', $this->dernierLogin);
                
                return $stmt->execute();
            } catch (Exception $e) {
                return false;
            }
        } 
        // Sinon, création d'un nouvel utilisateur
        else {
            try {
                $query = "INSERT INTO utilisateurs (username, email, password, date_inscription, dernier_login) 
                          VALUES (:username, :email, :password, :dateInscription, :dernierLogin)";
                
                $stmt = $db->getPdo()->prepare($query);
                
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':password', $this->password);
                $stmt->bindParam(':dateInscription', $this->dateInscription);
                $stmt->bindParam(':dernierLogin', $this->dernierLogin);
                
                $result = $stmt->execute();
                
                if ($result) {
                    $this->id = $db->getPdo()->lastInsertId();
                }
                
                return $result;
            } catch (Exception $e) {
                return false;
            }
        }
    }
    
    /**
     * Charger un utilisateur depuis la base de données
     * @param DatabaseController $db Contrôleur de base de données
     * @param int $id Identifiant de l'utilisateur
     * @return Utilisateur|null L'utilisateur chargé ou null en cas d'échec
     */
    public static function charger($db, $id) {
        try {
            $query = "SELECT * FROM utilisateurs WHERE id = :id";
            $stmt = $db->getPdo()->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                $utilisateur = new Utilisateur();
                $utilisateur->setId($data['id']);
                $utilisateur->setUsername($data['username']);
                $utilisateur->setEmail($data['email']);
                $utilisateur->password = $data['password']; // Assignation directe sans hachage
                $utilisateur->dateInscription = $data['date_inscription'];
                $utilisateur->dernierLogin = $data['dernier_login'];
                
                // Chargement des personnages associés
                // (à implémenter selon votre structure de base de données)
                
                return $utilisateur;
            }
            
            return null;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Authentifier un utilisateur
     * @param DatabaseController $db Contrôleur de base de données
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe
     * @return Utilisateur|null L'utilisateur authentifié ou null en cas d'échec
     */
    public static function authentifier($db, $username, $password) {
        try {
            $query = "SELECT * FROM utilisateurs WHERE username = :username";
            $stmt = $db->getPdo()->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                $utilisateur = new Utilisateur();
                $utilisateur->setId($data['id']);
                $utilisateur->setUsername($data['username']);
                $utilisateur->setEmail($data['email']);
                $utilisateur->password = $data['password']; // Assignation directe sans hachage
                $utilisateur->dateInscription = $data['date_inscription'];
                $utilisateur->dernierLogin = $data['dernier_login'];
                
                // Vérification du mot de passe
                if ($utilisateur->verifierPassword($password)) {
                    // Mise à jour de la date du dernier login
                    $utilisateur->mettreAJourLogin();
                    $utilisateur->sauvegarder($db);
                    
                    return $utilisateur;
                }
            }
            
            return null;
        } catch (Exception $e) {
            return null;
        }
    }
}