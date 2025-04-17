<?php
// Déterminer si nous sommes dans un sous-dossier
$inSubfolder = strpos($_SERVER['REQUEST_URI'], '/views/') !== false;
$rootPath = $inSubfolder ? '../' : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>RPG Manager</title>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>public/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <meta name="description" content="RPG Manager - Gérez vos personnages de jeu de rôle facilement">
    <meta name="robots" content="noindex, nofollow">
    <?php if (isset($additionalHead)) echo $additionalHead; ?>
</head>
<body class="fantasy-theme">
    <div class="background-container">
        <div class="background-overlay"></div>
    </div>
    
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="<?php echo $rootPath; ?>index.php">
                    <h1>RPG <span class="highlight">Manager</span></h1>
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo $rootPath; ?>index.php" class="<?php echo (!isset($currentPage) || $currentPage === 'home') ? 'active' : ''; ?>">Accueil</a></li>
                    <li><a href="<?php echo $rootPath; ?>views/personnage_form.php" class="<?php echo (isset($currentPage) && $currentPage === 'create') ? 'active' : ''; ?>">Créer un Personnage</a></li>
                    <li><a href="<?php echo $rootPath; ?>index.php#stats" class="<?php echo (isset($currentPage) && $currentPage === 'stats') ? 'active' : ''; ?>">Statistiques</a></li>
                </ul>
            </nav>
            <button class="mobile-menu-toggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
    
    <div class="main-container">
        <!-- Début contenu de la page -->