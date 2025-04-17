<?php
// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../src/Controller/PersonnageController.php';
require_once __DIR__ . '/../src/Utilitaire/Utilitaire.php';

// Protection contre les attaques CSRF
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Initialiser les variables
$message = '';
$messageType = '';
$erreurs = [];
$nom = '';
$genre = '';
$typeClasseId = '';
$force = '';
$agilite = '';
$intelligence = '';
$pointsDeVie = '';
$pointsDeMagie = '';
$isEdition = false;
$personnageId = null;

// Créer une instance du contrôleur
$controller = new PersonnageController();

// Récupérer tous les types de classes disponibles
$typeClasses = $controller->getTypeClasses();

// Vérifier si c'est une demande d'édition
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $personnageId = (int)$_GET['id'];
    $personnage = $controller->getPersonnage($personnageId);
    
    if ($personnage) {
        $isEdition = true;
        $nom = $personnage['nom'];
        $genre = $personnage['genre'];
        $typeClasseId = $personnage['type_classe_id'];
        $force = $personnage['force'];
        $agilite = $personnage['agilite'];
        $intelligence = $personnage['intelligence'];
        $pointsDeVie = $personnage['points_de_vie'];
        $pointsDeMagie = $personnage['points_de_magie'];
    } else {
        $message = "Personnage non trouvé.";
        $messageType = "error";
    }
}

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur de sécurité. Veuillez réessayer.');
    }
    
    // Récupération des données du formulaire
    $nom = $_POST['nom'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $typeClasseId = $_POST['typeClasseId'] ?? '';
    $force = $_POST['force'] ?? '';
    $agilite = $_POST['agilite'] ?? '';
    $intelligence = $_POST['intelligence'] ?? '';
    $pointsDeVie = $_POST['pointsDeVie'] ?? '';
    $pointsDeMagie = $_POST['pointsDeMagie'] ?? '';
    
    // Préparation des données pour validation
    $donnees = [
        'nom' => $nom,
        'genre' => $genre,
        'typeClasseId' => $typeClasseId,
        'force' => $force,
        'agilite' => $agilite,
        'intelligence' => $intelligence,
        'pointsDeVie' => $pointsDeVie,
        'pointsDeMagie' => $pointsDeMagie
    ];
    
    // Validation des données
    $erreurs = $controller->validerDonneesPersonnage($donnees, $isEdition ? $personnageId : null);
    
    // Si pas d'erreurs, enregistrer le personnage
    if (empty($erreurs)) {
        if ($isEdition && $personnageId) {
            // Modification d'un personnage existant
            $succes = $controller->modifierPersonnage(
                $personnageId, $nom, $genre, $typeClasseId, $force, $agilite, 
                $intelligence, $pointsDeVie, $pointsDeMagie
            );
            
            if ($succes) {
                $message = "Personnage modifié avec succès!";
                $messageType = "success";
            } else {
                $message = "Erreur lors de la modification du personnage.";
                $messageType = "error";
            }
        } else {
            // Création d'un nouveau personnage
            $succes = $controller->creerPersonnage(
                $nom, $genre, $typeClasseId, $force, $agilite, 
                $intelligence, $pointsDeVie, $pointsDeMagie
            );
            
            if ($succes) {
                $message = "Personnage créé avec succès!";
                $messageType = "success";
                
                // Réinitialiser les champs après la création
                $nom = '';
                $genre = '';
                $typeClasseId = '';
                $force = '';
                $agilite = '';
                $intelligence = '';
                $pointsDeVie = '';
                $pointsDeMagie = '';
            } else {
                $message = "Erreur lors de la création du personnage.";
                $messageType = "error";
            }
        }
        
        // Régénérer le token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $csrf_token = $_SESSION['csrf_token'];
    }
}

// Fonction pour l'autocomplétion des statistiques
function chargerValeursParDefaut() {
    global $controller;
    
    $script = "<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeClasseSelect = document.getElementById('typeClasseId');
        const forceInput = document.getElementById('force');
        const agiliteInput = document.getElementById('agilite');
        const intelligenceInput = document.getElementById('intelligence');
        const pointsDeVieInput = document.getElementById('pointsDeVie');
        const pointsDeMagieInput = document.getElementById('pointsDeMagie');
        
        // Fonction pour marquer un champ comme modifié
        function markAsModified(input) {
            input.dataset.modified = 'true';
            input.classList.add('user-modified');
        }
        
        // Ajouter des écouteurs pour marquer les champs comme modifiés
        [forceInput, agiliteInput, intelligenceInput, pointsDeVieInput, pointsDeMagieInput].forEach(input => {
            input.addEventListener('input', function() {
                markAsModified(this);
            });
        });
        
        // Fonction pour mettre à jour les statistiques selon la classe
        function updateStats() {
            const typeClasseId = typeClasseSelect.value;
            
            if (!typeClasseId) return;
            
            fetch('../ajax/get_classe_stats.php?id=' + typeClasseId)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        // Mise à jour des champs non modifiés
                        if (!forceInput.dataset.modified) {
                            forceInput.value = data.force;
                        }
                        if (!agiliteInput.dataset.modified) {
                            agiliteInput.value = data.agilite;
                        }
                        if (!intelligenceInput.dataset.modified) {
                            intelligenceInput.value = data.intelligence;
                        }
                        if (!pointsDeVieInput.dataset.modified) {
                            pointsDeVieInput.value = data.pointsDeVie;
                        }
                        if (!pointsDeMagieInput.dataset.modified) {
                            pointsDeMagieInput.value = data.pointsDeMagie;
                        }
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }
        
        // Écouter les changements de type de classe
        typeClasseSelect.addEventListener('change', updateStats);
        
        // Initialiser les statistiques si un type de classe est déjà sélectionné
        if (typeClasseSelect.value) {
            updateStats();
        }
    });
    </script>";
    
    return $script;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdition ? 'Modifier un personnage' : 'Créer un personnage'; ?> - RPG Manager</title>
    <link rel="stylesheet" href="../public/style.css">
    <meta name="robots" content="noindex, nofollow">
    <?php echo chargerValeursParDefaut(); ?>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <div class="main-container">
        <h1 class="text-center mb-3"><?php echo $isEdition ? 'Modifier un personnage' : 'Créer un personnage'; ?></h1>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="" class="secure-form">
            <!-- Token CSRF pour la sécurité -->
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <?php if ($isEdition): ?>
                <input type="hidden" name="id" value="<?php echo $personnageId; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="nom">Nom du personnage:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" class="<?php echo isset($erreurs['nom']) ? 'error' : ''; ?>" maxlength="50" required>
                <?php if (isset($erreurs['nom'])): ?>
                    <span class="error-message"><?php echo $erreurs['nom']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="genre">Genre:</label>
                <select id="genre" name="genre" class="<?php echo isset($erreurs['genre']) ? 'error' : ''; ?>" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Homme" <?php if ($genre === 'Homme') echo 'selected'; ?>>Homme</option>
                    <option value="Femme" <?php if ($genre === 'Femme') echo 'selected'; ?>>Femme</option>
                    <option value="Autre" <?php if ($genre === 'Autre') echo 'selected'; ?>>Autre</option>
                </select>
                <?php if (isset($erreurs['genre'])): ?>
                    <span class="error-message"><?php echo $erreurs['genre']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="typeClasseId">Classe:</label>
                <select id="typeClasseId" name="typeClasseId" class="<?php echo isset($erreurs['typeClasseId']) ? 'error' : ''; ?>" required>
                    <option value="">-- Sélectionnez --</option>
                    <?php foreach ($typeClasses as $typeClasse): ?>
                        <option value="<?php echo $typeClasse['id']; ?>" <?php if ($typeClasseId == $typeClasse['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($typeClasse['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($erreurs['typeClasseId'])): ?>
                    <span class="error-message"><?php echo $erreurs['typeClasseId']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="force">Force:</label>
                <input type="number" id="force" name="force" min="1" max="100" value="<?php echo htmlspecialchars($force); ?>" class="<?php echo isset($erreurs['force']) ? 'error' : ''; ?>" required>
                <?php if (isset($erreurs['force'])): ?>
                    <span class="error-message"><?php echo $erreurs['force']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="agilite">Agilité:</label>
                <input type="number" id="agilite" name="agilite" min="1" max="100" value="<?php echo htmlspecialchars($agilite); ?>" class="<?php echo isset($erreurs['agilite']) ? 'error' : ''; ?>" required>
                <?php if (isset($erreurs['agilite'])): ?>
                    <span class="error-message"><?php echo $erreurs['agilite']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="intelligence">Intelligence:</label>
                <input type="number" id="intelligence" name="intelligence" min="1" max="100" value="<?php echo htmlspecialchars($intelligence); ?>" class="<?php echo isset($erreurs['intelligence']) ? 'error' : ''; ?>" required>
                <?php if (isset($erreurs['intelligence'])): ?>
                    <span class="error-message"><?php echo $erreurs['intelligence']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="pointsDeVie">Points de vie:</label>
                <input type="number" id="pointsDeVie" name="pointsDeVie" min="50" max="1000" value="<?php echo htmlspecialchars($pointsDeVie); ?>" class="<?php echo isset($erreurs['pointsDeVie']) ? 'error' : ''; ?>" required>
                <?php if (isset($erreurs['pointsDeVie'])): ?>
                    <span class="error-message"><?php echo $erreurs['pointsDeVie']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="pointsDeMagie">Points de magie:</label>
                <input type="number" id="pointsDeMagie" name="pointsDeMagie" min="0" max="1000" value="<?php echo htmlspecialchars($pointsDeMagie); ?>" class="<?php echo isset($erreurs['pointsDeMagie']) ? 'error' : ''; ?>" required>
                <?php if (isset($erreurs['pointsDeMagie'])): ?>
                    <span class="error-message"><?php echo $erreurs['pointsDeMagie']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group button-group">
                <button type="submit"><?php echo $isEdition ? 'Modifier' : 'Créer'; ?> le personnage</button>
                <button type="button" onclick="location.href='../index.php'" class="secondary">Annuler</button>
            </div>
        </form>
    </div>
    
    <?php include 'partials/footer.php'; ?>
    
    <script src="../public/main.js"></script>
</body>
</html>