<?php
// Inclusion des fichiers nécessaires
require_once __DIR__ . '/src/Controller/PersonnageController.php';
require_once __DIR__ . '/src/Utilitaire/Utilitaire.php';

// Initialisation de la session
session_start();

// Traitement des actions (suppression)
$message = '';
$messageType = '';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // Vérification du token CSRF pour la suppression
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Erreur de sécurité. Veuillez réessayer.";
        $messageType = "error";
    } else {
        $controller = new PersonnageController();
        $succes = $controller->supprimerPersonnage($_GET['id']);
        
        if ($succes) {
            $message = "Personnage supprimé avec succès!";
            $messageType = "success";
        } else {
            $message = "Erreur lors de la suppression du personnage.";
            $messageType = "error";
        }
        
        // Régénérer le token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Générer un token CSRF s'il n'existe pas déjà
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Récupération de tous les personnages
$controller = new PersonnageController();
$personnages = $controller->getListePersonnagesInstances();

// Récupération de tous les types de classes pour les statistiques
$typeClasses = $controller->getTypeClasses();
$statsPersonnages = $controller->countPersonnagesByTypeClasse();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Manager - Gestion des Personnages</title>
    <link rel="stylesheet" href="public/style.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>RPG <span class="highlight">Manager</span></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Accueil</a></li>
                    <li><a href="views/personnage_form.php">Créer un Personnage</a></li>
                    <li><a href="#stats">Statistiques</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <div class="hero-section">
            <h1>Bienvenue dans RPG Manager</h1>
            <p>Gérez vos personnages de jeu de rôle avec facilité et style.</p>
            <a href="views/personnage_form.php" class="cta-button">Créer un nouveau personnage</a>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <section>
            <h2>Vos personnages</h2>
            <?php if (empty($personnages)): ?>
                <div class="empty-state">
                    <p>Vous n'avez pas encore créé de personnages.</p>
                    <a href="views/personnage_form.php" class="button">Créer votre premier personnage</a>
                </div>
            <?php else: ?>
                <div class="character-grid">
                <?php foreach ($personnages as $personnage): ?>
    <?php 
    // Convertir le nom de la classe en minuscules pour la classe CSS
    $classeCSS = strtolower($personnage->getClasse());
    ?>
    <div class="character-card <?php echo $classeCSS; ?>">
        <div class="card-header">
            <h3><?php echo htmlspecialchars($personnage->getNom()); ?></h3>
            <span class="class-badge"><?php echo htmlspecialchars($personnage->getClasse()); ?></span>
        </div>
        
        <div class="card-body">
            <div class="stat"><span class="stat-name">Genre:</span> <span class="stat-value"><?php echo htmlspecialchars($personnage->getGenre()); ?></span></div>
            <div class="stat"><span class="stat-name">Force:</span> <span class="stat-value"><?php echo $personnage->getForce(); ?></span></div>
            <div class="stat"><span class="stat-name">Agilité:</span> <span class="stat-value"><?php echo $personnage->getAgilite(); ?></span></div>
            <div class="stat"><span class="stat-name">Intelligence:</span> <span class="stat-value"><?php echo $personnage->getIntelligence(); ?></span></div>
            
            <div class="stat">
                <span class="stat-name">Points de Vie:</span> <span class="stat-value"><?php echo $personnage->getPointsDeVie(); ?></span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo min(100, $personnage->getPointsDeVie() / 10); ?>%"></div>
                </div>
            </div>
            
            <div class="stat">
                <span class="stat-name">Points de Magie:</span> <span class="stat-value"><?php echo $personnage->getPointsDeMagie(); ?></span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo min(100, $personnage->getPointsDeMagie() / 10); ?>%"></div>
                </div>
            </div>
        </div>
        
        <div class="card-actions">
            <a href="views/personnage_form.php?action=edit&id=<?php echo $personnage->getId(); ?>" class="button">Modifier</a>
            <a href="index.php?action=delete&id=<?php echo $personnage->getId(); ?>&csrf_token=<?php echo $csrf_token; ?>" class="button danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce personnage?')">Supprimer</a>
        </div>
    </div>
<?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        
        <?php if (!empty($statsPersonnages)): ?>
        <section id="stats">
            <h2>Statistiques des classes</h2>
            <div class="stats-container">
                <div class="stats-chart">
                    <?php foreach ($statsPersonnages as $stat): ?>
                        <div class="stat-bar">
                            <div class="stat-label"><?php echo htmlspecialchars($stat['classe']); ?></div>
                            <div class="stat-value-bar" style="width: <?php echo ($stat['total'] > 0) ? min(100, $stat['total'] * 20) : 5; ?>%">
                                <span class="stat-number"><?php echo $stat['total']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="stats-info">
                    <h3>Répartition des personnages</h3>
                    <p>Ce graphique montre le nombre de personnages créés pour chaque classe.</p>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
        <?php if (count($personnages) >= 2): ?>
        <section class="demo-section">
            <h2>Démonstration du Polymorphisme</h2>
            <div class="demo-box">
                <h3>Vos personnages en action</h3>
                <div class="demo-content">
                    <?php 
                    $demoContent = $controller->demoPolymorphisme();
                    // Séparer les lignes et les envelopper dans des éléments pour un meilleur styling
                    $lines = explode('<br>', $demoContent);
                    foreach ($lines as $line) {
                        if (!empty(trim($line))) {
                            echo '<div class="demo-line">' . $line . '</div>';
                        }
                    }
                    ?>
                </div>
                
                <div class="demo-explanation">
                    <h4>Comment fonctionne le polymorphisme ?</h4>
                    <p>Le polymorphisme permet à différentes classes d'utiliser une même méthode, mais avec des comportements spécifiques :</p>
                    <ul>
                        <li>Les <strong>Guerriers</strong> attaquent avec une épée</li>
                        <li>Les <strong>Mages</strong> lancent des sorts</li>
                        <li>Les <strong>Archers</strong> tirent des flèches</li>
                    </ul>
                    <p>Tous utilisent la méthode <code>attaquer()</code>, mais chaque classe l'implémente différemment.</p>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </div>
    
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>RPG Manager</h3>
                <p>Système de gestion des personnages pour jeux de rôle</p>
            </div>
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="views/personnage_form.php">Créer un Personnage</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Classes</h3>
                <ul>
                    <?php foreach ($typeClasses as $typeClasse): ?>
                        <li><?php echo htmlspecialchars($typeClasse['nom']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> RPG Manager. Tous droits réservés.</p>
        </div>
    </footer>
    
    <script src="public/main.js"></script>
</body>
</html>