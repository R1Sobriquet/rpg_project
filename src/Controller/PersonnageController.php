<?php
require_once __DIR__ . '/../Model/PersonnageModel.php';
require_once __DIR__ . '/../Model/TypeClasseModel.php';
require_once __DIR__ . '/../Entity/Personnage.php';
require_once __DIR__ . '/../Entity/Guerrier.php';
require_once __DIR__ . '/../Entity/Mage.php';
require_once __DIR__ . '/../Entity/Archer.php';

class PersonnageController {
    private $model;
    private $typeClasseModel;
    
    /**
     * Constructeur du contrôleur de personnages
     */
    public function __construct() {
        $this->model = new PersonnageModel();
        $this->typeClasseModel = new TypeClasseModel();
    }
    
    /**
     * Récupère tous les types de classes disponibles
     * 
     * @return array Liste des types de classes
     */
    public function getTypeClasses() {
        return $this->typeClasseModel->getAllTypeClasses();
    }
    
    /**
     * Récupère un type de classe par son ID
     * 
     * @param int $id ID du type de classe
     * @return array Informations sur le type de classe
     */
    public function getTypeClasse($id) {
        return $this->typeClasseModel->getTypeClasseById($id);
    }
    
    /**
     * Crée un nouveau personnage et l'enregistre dans la base de données
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
    public function creerPersonnage($nom, $genre, $typeClasseId, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        // Valider les données
        if (empty($nom) || empty($genre) || empty($typeClasseId) || 
            !is_numeric($force) || !is_numeric($agilite) || 
            !is_numeric($intelligence) || !is_numeric($pointsDeVie) || 
            !is_numeric($pointsDeMagie)) {
            return false;
        }
        
        // Vérifier que le type de classe existe
        $typeClasse = $this->typeClasseModel->getTypeClasseById($typeClasseId);
        if (!$typeClasse) {
            return false;
        }
        
        // Sanitisation des données
        $nom = htmlspecialchars(trim($nom));
        $genre = htmlspecialchars(trim($genre));
        $force = (int)$force;
        $agilite = (int)$agilite;
        $intelligence = (int)$intelligence;
        $pointsDeVie = (int)$pointsDeVie;
        $pointsDeMagie = (int)$pointsDeMagie;
        
        // Enregistrer dans la base de données
        return $this->model->insertPersonnage($nom, $genre, $typeClasseId, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie);
    }
    
    /**
     * Récupère tous les personnages
     * 
     * @return array Liste des personnages
     */
    public function listePersonnages() {
        return $this->model->getAllPersonnages();
    }
    
    /**
     * Récupère un personnage par son ID
     * 
     * @param int $id ID du personnage
     * @return array|bool Données du personnage ou false
     */
    public function getPersonnage($id) {
        return $this->model->getPersonnageById($id);
    }

    // Dans PersonnageController.php, ajoutez cette méthode
public function countPersonnagesByTypeClasse() {
    return $this->model->countPersonnagesByTypeClasse();
}
    
    /**
     * Met à jour un personnage existant
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
    public function modifierPersonnage($id, $nom, $genre, $typeClasseId, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie) {
        // Valider les données
        if (empty($id) || empty($nom) || empty($genre) || empty($typeClasseId) || 
            !is_numeric($force) || !is_numeric($agilite) || 
            !is_numeric($intelligence) || !is_numeric($pointsDeVie) || 
            !is_numeric($pointsDeMagie)) {
            return false;
        }
        
        // Vérifier que le type de classe existe
        $typeClasse = $this->typeClasseModel->getTypeClasseById($typeClasseId);
        if (!$typeClasse) {
            return false;
        }
        
        // Sanitisation des données
        $id = (int)$id;
        $nom = htmlspecialchars(trim($nom));
        $genre = htmlspecialchars(trim($genre));
        $typeClasseId = (int)$typeClasseId;
        $force = (int)$force;
        $agilite = (int)$agilite;
        $intelligence = (int)$intelligence;
        $pointsDeVie = (int)$pointsDeVie;
        $pointsDeMagie = (int)$pointsDeMagie;
        
        // Mettre à jour dans la base de données
        return $this->model->updatePersonnage($id, $nom, $genre, $typeClasseId, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie);
    }
    
    /**
     * Supprime un personnage
     * 
     * @param int $id ID du personnage
     * @return bool Succès de l'opération
     */
    public function supprimerPersonnage($id) {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }
        
        return $this->model->deletePersonnage($id);
    }
    
    /**
     * Obtient les valeurs par défaut d'un type de classe
     * 
     * @param int $typeClasseId ID du type de classe
     * @return array Valeurs par défaut ou tableau vide
     */
    public function getValeursParDefaut($typeClasseId) {
        $typeClasse = $this->typeClasseModel->getTypeClasseById($typeClasseId);
        
        if ($typeClasse) {
            return [
                'force' => $typeClasse['force_base'],
                'agilite' => $typeClasse['agilite_base'],
                'intelligence' => $typeClasse['intelligence_base'],
                'pointsDeVie' => $typeClasse['points_de_vie_base'],
                'pointsDeMagie' => $typeClasse['points_de_magie_base']
            ];
        }
        
        return [
            'force' => 0,
            'agilite' => 0,
            'intelligence' => 0,
            'pointsDeVie' => 0,
            'pointsDeMagie' => 0
        ];
    }
    
    /**
     * Crée l'instance de personnage appropriée selon la classe
     * 
     * @param array $data Données du personnage
     * @return Personnage|null Instance du personnage créé ou null
     */
    public function creerInstancePersonnage($data) {
        if (!isset($data['id'], $data['nom'], $data['genre'], $data['type_classe_id'], 
                  $data['force'], $data['agilite'], $data['intelligence'], 
                  $data['points_de_vie'], $data['points_de_magie'], $data['classe_nom'])) {
            return null;
        }
        
        $personnage = null;
        $classe = $data['classe_nom'];
        
        switch ($classe) {
            case 'Guerrier':
                $personnage = new Guerrier(
                    $data['nom'],
                    $data['genre'],
                    $classe,
                    $data['force'],
                    $data['agilite'],
                    $data['intelligence'],
                    $data['points_de_vie'],
                    $data['points_de_magie']
                );
                break;
                
            case 'Mage':
                $personnage = new Mage(
                    $data['nom'],
                    $data['genre'],
                    $classe,
                    $data['force'],
                    $data['agilite'],
                    $data['intelligence'],
                    $data['points_de_vie'],
                    $data['points_de_magie']
                );
                break;
                
            case 'Archer':
                $personnage = new Archer(
                    $data['nom'],
                    $data['genre'],
                    $classe,
                    $data['force'],
                    $data['agilite'],
                    $data['intelligence'],
                    $data['points_de_vie'],
                    $data['points_de_magie']
                );
                break;
        }
        
        if ($personnage) {
            $personnage->setId($data['id']);
        }
        
        return $personnage;
    }
    
    /**
     * Génère une liste d'instances de personnages à partir des données de la base
     * 
     * @return array Liste d'instances de personnages
     */
    public function getListePersonnagesInstances() {
        $donnees = $this->listePersonnages();
        $personnages = [];
        
        foreach ($donnees as $data) {
            $personnage = $this->creerInstancePersonnage($data);
            if ($personnage) {
                $personnages[] = $personnage;
            }
        }
        
        return $personnages;
    }
    
    /**
     * Démonstration du polymorphisme avec les personnages qui attaquent
     * 
     * @return string Résultat des attaques
     */
    public function demoPolymorphisme() {
        $personnages = $this->getListePersonnagesInstances();
        
        if (count($personnages) < 2) {
            return "Il faut au moins deux personnages pour démontrer le polymorphisme.";
        }
        
        $cible = $personnages[0]; // Première cible
        $resultat = "";
        
        // Tous les personnages attaquent la cible
        for ($i = 1; $i < count($personnages); $i++) {
            ob_start();
            $personnages[$i]->attaquer($cible);
            $resultat .= ob_get_clean() . "<br>";
        }
        
        return $resultat;
    }
    
    /**
     * Vérifie si un nom de personnage existe déjà
     * 
     * @param string $nom Nom à vérifier
     * @param int $ignorerId ID du personnage à ignorer (pour l'édition)
     * @return bool True si le nom existe déjà
     */
    public function nomPersonnageExiste($nom, $ignorerId = null) {
        $personnages = $this->listePersonnages();
        
        foreach ($personnages as $personnage) {
            if (strtolower($personnage['nom']) === strtolower($nom) && 
                ($ignorerId === null || $personnage['id'] != $ignorerId)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Valide les données d'un personnage
     * 
     * @param array $data Données à valider
     * @param int $ignorerId ID du personnage à ignorer (pour l'édition)
     * @return array Tableau des erreurs (vide si pas d'erreurs)
     */
    public function validerDonneesPersonnage($data, $ignorerId = null) {
        $erreurs = [];
        
        // Validation du nom
        if (empty($data['nom'])) {
            $erreurs['nom'] = "Le nom est obligatoire.";
        } elseif (strlen($data['nom']) < 2 || strlen($data['nom']) > 50) {
            $erreurs['nom'] = "Le nom doit contenir entre 2 et 50 caractères.";
        } elseif (!preg_match('/^[a-zA-Z0-9\s\-_]+$/', $data['nom'])) {
            $erreurs['nom'] = "Le nom contient des caractères non autorisés.";
        } elseif ($this->nomPersonnageExiste($data['nom'], $ignorerId)) {
            $erreurs['nom'] = "Ce nom de personnage existe déjà.";
        }
        
        // Validation du genre
        if (empty($data['genre'])) {
            $erreurs['genre'] = "Le genre est obligatoire.";
        } elseif (!in_array($data['genre'], ['Homme', 'Femme', 'Autre'])) {
            $erreurs['genre'] = "Le genre doit être Homme, Femme ou Autre.";
        }
        
        // Validation du type de classe
        if (empty($data['typeClasseId'])) {
            $erreurs['typeClasseId'] = "La classe est obligatoire.";
        } else {
            $typeClasse = $this->getTypeClasse($data['typeClasseId']);
            if (!$typeClasse) {
                $erreurs['typeClasseId'] = "La classe sélectionnée n'existe pas.";
            }
        }
        
        // Validation des statistiques numériques
        $stats = [
            'force' => ["min" => 1, "max" => 100, "name" => "Force"],
            'agilite' => ["min" => 1, "max" => 100, "name" => "Agilité"],
            'intelligence' => ["min" => 1, "max" => 100, "name" => "Intelligence"],
            'pointsDeVie' => ["min" => 50, "max" => 1000, "name" => "Points de vie"],
            'pointsDeMagie' => ["min" => 0, "max" => 1000, "name" => "Points de magie"]
        ];
        
        foreach ($stats as $key => $param) {
            if (!isset($data[$key]) || $data[$key] === '') {
                $erreurs[$key] = $param["name"] . " est obligatoire.";
            } elseif (!is_numeric($data[$key])) {
                $erreurs[$key] = $param["name"] . " doit être un nombre.";
            } elseif ((int)$data[$key] < $param["min"]) {
                $erreurs[$key] = $param["name"] . " doit être supérieur ou égal à " . $param["min"] . ".";
            } elseif ((int)$data[$key] > $param["max"]) {
                $erreurs[$key] = $param["name"] . " doit être inférieur ou égal à " . $param["max"] . ".";
            }
        }
        
        return $erreurs;
    }
}