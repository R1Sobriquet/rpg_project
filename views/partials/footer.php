<!-- Fin contenu de la page -->
</div>
    
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>RPG <span class="highlight">Manager</span></h3>
                <p>Système avancé de gestion des personnages pour jeux de rôle</p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="icon-facebook"></i></a>
                    <a href="#" aria-label="Twitter"><i class="icon-twitter"></i></a>
                    <a href="#" aria-label="Discord"><i class="icon-discord"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="<?php echo isset($inSubfolder) && $inSubfolder ? '../' : ''; ?>index.php">Accueil</a></li>
                    <li><a href="<?php echo isset($inSubfolder) && $inSubfolder ? '' : 'views/'; ?>personnage_form.php">Créer un Personnage</a></li>
                    <li><a href="<?php echo isset($inSubfolder) && $inSubfolder ? '../' : ''; ?>index.php#stats">Statistiques</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Classes de personnages</h3>
                <ul>
                    <?php 
                    // Récupérer les types de classes s'ils ne sont pas déjà définis
                    if (!isset($typeClasses) && class_exists('PersonnageController')) {
                        $tempController = new PersonnageController();
                        $typeClasses = $tempController->getTypeClasses();
                    }
                    
                    if (isset($typeClasses) && is_array($typeClasses)): 
                        foreach ($typeClasses as $typeClasse): 
                    ?>
                        <li><?php echo htmlspecialchars($typeClasse['nom']); ?></li>
                    <?php 
                        endforeach;
                    else:
                    ?>
                        <li>Guerrier</li>
                        <li>Mage</li>
                        <li>Archer</li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Ressources</h3>
                <ul>
                    <li><a href="#">Guide du débutant</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Nous contacter</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> RPG Manager. Tous droits réservés.</p>
            <p class="credits">Conçu avec <span class="heart">❤</span> pour les passionnés de jeux de rôle</p>
        </div>
    </footer>
    
    <?php if (isset($inSubfolder) && $inSubfolder): ?>
    <script src="../public/main.js"></script>
    <?php else: ?>
    <script src="public/main.js"></script>
    <?php endif; ?>
    
    <?php if (isset($additionalScripts)) echo $additionalScripts; ?>
</body>
</html>