<?php
// Inclure la classe Database
require_once '../src/controllers/DatabaseController.php';

// Initialiser les variables
$message = '';
$nom = '';
$genre = '';
$classe = '';
$force = '';
$agilite = '';
$intelligence = '';
$pointsDeVie = '';
$pointsDeMagie = '';

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $classe = $_POST['classe'] ?? '';
    $force = $_POST['force'] ?? '';
    $agilite = $_POST['agilite'] ?? '';
    $intelligence = $_POST['intelligence'] ?? '';
    $pointsDeVie = $_POST['pointsDeVie'] ?? '';
    $pointsDeMagie = $_POST['pointsDeMagie'] ?? '';
    
    // Validation simple
    if (empty($nom) || empty($genre) || empty($classe) || 
        !is_numeric($force) || !is_numeric($agilite) || 
        !is_numeric($intelligence) || !is_numeric($pointsDeVie) || 
        !is_numeric($pointsDeMagie)) {
        
        $message = 'Tous les champs sont obligatoires et les caractéristiques doivent être numériques.';
    } else {
        // Tous les champs sont valides, sauvegarde dans la base de données
        $db = new DatabaseController();
        
        if ($db->insertPersonnage($nom, $genre, $classe, $force, $agilite, $intelligence, $pointsDeVie, $pointsDeMagie)) {
            $message = 'Personnage créé avec succès!';
            
            // Réinitialiser les champs après la création
            $nom = '';
            $genre = '';
            $classe = '';
            $force = '';
            $agilite = '';
            $intelligence = '';
            $pointsDeVie = '';
            $pointsDeMagie = '';
        } else {
            $message = 'Erreur lors de la création du personnage.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de personnage RPG</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <main>
        <h1>Création de personnage</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="nom">Nom du personnage:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="genre">Genre:</label>
                <select id="genre" name="genre" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Homme" <?php if ($genre === 'Homme') echo 'selected'; ?>>Homme</option>
                    <option value="Femme" <?php if ($genre === 'Femme') echo 'selected'; ?>>Femme</option>
                    <option value="Autre" <?php if ($genre === 'Autre') echo 'selected'; ?>>Autre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="classe">Classe:</label>
                <select id="classe" name="classe" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Guerrier" <?php if ($classe === 'Guerrier') echo 'selected'; ?>>Guerrier</option>
                    <option value="Mage" <?php if ($classe === 'Mage') echo 'selected'; ?>>Mage</option>
                    <option value="Archer" <?php if ($classe === 'Archer') echo 'selected'; ?>>Archer</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="force">Force:</label>
                <input type="number" id="force" name="force" min="1" max="100" value="<?php echo htmlspecialchars($force); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="agilite">Agilité:</label>
                <input type="number" id="agilite" name="agilite" min="1" max="100" value="<?php echo htmlspecialchars($agilite); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="intelligence">Intelligence:</label>
                <input type="number" id="intelligence" name="intelligence" min="1" max="100" value="<?php echo htmlspecialchars($intelligence); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="pointsDeVie">Points de vie:</label>
                <input type="number" id="pointsDeVie" name="pointsDeVie" min="1" max="1000" value="<?php echo htmlspecialchars($pointsDeVie); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="pointsDeMagie">Points de magie:</label>
                <input type="number" id="pointsDeMagie" name="pointsDeMagie" min="0" max="1000" value="<?php echo htmlspecialchars($pointsDeMagie); ?>" required>
            </div>
            
            <div class="form-group">
                <button type="submit">Créer le personnage</button>
            </div>
        </form>
    </main>
    
    <?php include 'partials/footer.php'; ?>
</body>
</html>