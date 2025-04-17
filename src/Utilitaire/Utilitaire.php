<?php
require_once __DIR__ . '/../Entity/Personnage.php';


class Utilitaire {
    /**
     * Méthode statique pour afficher les détails d'un personnage
     * 
     * @param Personnage $personnage Le personnage à afficher
     * @return string HTML contenant les informations du personnage
     */
    public static function afficherPersonnage($personnage) {
        $output = "<div class='character-info'>";
        $output .= "<p><strong>Nom:</strong> " . htmlspecialchars($personnage->getNom()) . "</p>";
        $output .= "<p><strong>Genre:</strong> " . htmlspecialchars($personnage->getGenre()) . "</p>";
        $output .= "<p><strong>Classe:</strong> " . htmlspecialchars($personnage->getClasse()) . "</p>";
        $output .= "<p><strong>Force:</strong> " . $personnage->getForce() . "</p>";
        $output .= "<p><strong>Agilité:</strong> " . $personnage->getAgilite() . "</p>";
        $output .= "<p><strong>Intelligence:</strong> " . $personnage->getIntelligence() . "</p>";
        $output .= "<p><strong>Points de Vie:</strong> " . $personnage->getPointsDeVie() . "</p>";
        $output .= "<p><strong>Points de Magie:</strong> " . $personnage->getPointsDeMagie() . "</p>";
        $output .= "</div>";
        
        return $output;
    }
    
    /**
     * Génère une carte stylisée pour un personnage
     * 
     * @param Personnage $personnage Le personnage à afficher
     * @return string HTML de la carte du personnage
     */
    public static function genererCartePersonnage($personnage) {
        $classeCSS = strtolower($personnage->getClasse());
        
        $html = "<div class='character-card {$classeCSS}'>";
        $html .= "<div class='card-header'>";
        $html .= "<h3>" . htmlspecialchars($personnage->getNom()) . "</h3>";
        $html .= "<span class='class-badge'>" . htmlspecialchars($personnage->getClasse()) . "</span>";
        $html .= "</div>";
        
        $html .= "<div class='card-body'>";
        
        // Statistiques principales
        $html .= "<div class='stat'><span class='stat-name'>Genre:</span> <span class='stat-value'>" . htmlspecialchars($personnage->getGenre()) . "</span></div>";
        $html .= "<div class='stat'><span class='stat-name'>Force:</span> <span class='stat-value'>" . $personnage->getForce() . "</span></div>";
        $html .= "<div class='stat'><span class='stat-name'>Agilité:</span> <span class='stat-value'>" . $personnage->getAgilite() . "</span></div>";
        $html .= "<div class='stat'><span class='stat-name'>Intelligence:</span> <span class='stat-value'>" . $personnage->getIntelligence() . "</span></div>";
        
        // Barres de progression pour les points de vie et de magie
        $html .= "<div class='stat'>";
        $html .= "<span class='stat-name'>Points de Vie:</span> <span class='stat-value'>" . $personnage->getPointsDeVie() . "</span>";
        $html .= "<div class='progress-bar'><div class='progress-fill' style='width: " . min(100, $personnage->getPointsDeVie() / 2) . "%'></div></div>";
        $html .= "</div>";
        
        $html .= "<div class='stat'>";
        $html .= "<span class='stat-name'>Points de Magie:</span> <span class='stat-value'>" . $personnage->getPointsDeMagie() . "</span>";
        $html .= "<div class='progress-bar'><div class='progress-fill' style='width: " . min(100, $personnage->getPointsDeMagie() / 2) . "%'></div></div>";
        $html .= "</div>";
        
        $html .= "</div>"; // fin card-body
        
        // Actions
        $html .= "<div class='card-actions'>";
        $html .= "<button onclick='location.href=\"?action=edit&id=" . $personnage->getId() . "\"'>Modifier</button>";
        $html .= "<button onclick='if(confirm(\"Êtes-vous sûr de vouloir supprimer ce personnage?\")) location.href=\"?action=delete&id=" . $personnage->getId() . "\"'>Supprimer</button>";
        $html .= "</div>";
        
        $html .= "</div>"; // fin character-card
        
        return $html;
    }
    
    /**
     * Génère le HTML pour afficher une grille de personnages
     * 
     * @param array $personnages Liste des personnages à afficher
     * @return string HTML de la grille de personnages
     */
    public static function afficherGrillePersonnages($personnages) {
        if (empty($personnages)) {
            return "<div class='message'>Aucun personnage trouvé.</div>";
        }
        
        $html = "<div class='character-grid'>";
        
        foreach ($personnages as $personnage) {
            $html .= self::genererCartePersonnage($personnage);
        }
        
        $html .= "</div>";
        
        return $html;
    }
    
    /**
     * Valide les données d'un formulaire de personnage
     * 
     * @param array $data Données à valider
     * @return array Tableau contenant les erreurs éventuelles
     */
    public static function validerDonneesPersonnage($data) {
        $erreurs = [];
        
        // Validation du nom
        if (empty($data['nom'])) {
            $erreurs['nom'] = "Le nom est obligatoire.";
        } elseif (strlen($data['nom']) < 2 || strlen($data['nom']) > 50) {
            $erreurs['nom'] = "Le nom doit contenir entre 2 et 50 caractères.";
        }
        
        // Validation du genre
        if (empty($data['genre'])) {
            $erreurs['genre'] = "Le genre est obligatoire.";
        }
        
        // Validation de la classe
        if (empty($data['classe'])) {
            $erreurs['classe'] = "La classe est obligatoire.";
        } elseif (!in_array($data['classe'], ['Guerrier', 'Mage', 'Archer'])) {
            $erreurs['classe'] = "La classe doit être Guerrier, Mage ou Archer.";
        }
        
        // Validation des statistiques numériques
        $stats = ['force', 'agilite', 'intelligence', 'pointsDeVie', 'pointsDeMagie'];
        
        foreach ($stats as $stat) {
            if (!isset($data[$stat]) || $data[$stat] === '') {
                $erreurs[$stat] = "Ce champ est obligatoire.";
            } elseif (!is_numeric($data[$stat])) {
                $erreurs[$stat] = "Ce champ doit être un nombre.";
            } elseif ($data[$stat] < 1) {
                $erreurs[$stat] = "Ce champ doit être supérieur à 0.";
            } elseif ($stat === 'pointsDeVie' && $data[$stat] < 50) {
                $erreurs[$stat] = "Les points de vie doivent être au moins de 50.";
            }
        }
        
        return $erreurs;
    }
    
    /**
     * Génère des statistiques de base selon la classe du personnage
     * 
     * @param string $classe Classe du personnage
     * @return array Statistiques par défaut
     */
    public static function getStatistiquesParDefaut($classe) {
        switch ($classe) {
            case 'Guerrier':
                return [
                    'force' => 70,
                    'agilite' => 50,
                    'intelligence' => 30,
                    'pointsDeVie' => 200,
                    'pointsDeMagie' => 50
                ];
                
            case 'Mage':
                return [
                    'force' => 30,
                    'agilite' => 40,
                    'intelligence' => 80,
                    'pointsDeVie' => 100,
                    'pointsDeMagie' => 200
                ];
                
            case 'Archer':
                return [
                    'force' => 50,
                    'agilite' => 75,
                    'intelligence' => 50,
                    'pointsDeVie' => 150,
                    'pointsDeMagie' => 80
                ];
                
            default:
                return [
                    'force' => 50,
                    'agilite' => 50,
                    'intelligence' => 50,
                    'pointsDeVie' => 100,
                    'pointsDeMagie' => 100
                ];
        }
    }
}