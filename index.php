<?php
// Inclusion des fichiers nécessaires
require_once 'src/controllers/PersonnageController.php';
require_once 'src/controllers/GuerrierController.php';
require_once 'src/controllers/MageController.php';
require_once 'src/controllers/ArcherController.php';
require_once 'src/controllers/UtilityController.php';
require_once 'src/interfaces/Combatant.php';

// Exemple d'utilisation du système RPG pour démontrer les fonctionnalités

// Création des personnages
$guerrier = new Guerrier("Aragorn", "Homme", "Guerrier", 80, 60, 40, 200, 30);
$mage = new Mage("Gandalf", "Homme", "Mage", 30, 40, 90, 100, 200);
$archer = new Archer("Legolas", "Homme", "Archer", 50, 85, 60, 150, 50);

// Affichage des détails des personnages avec la méthode statique
echo "<h2>Détails des personnages</h2>";
echo "<h3>Guerrier</h3>";
echo "<pre>";
UtilityController::afficherPersonnage($guerrier);
echo "</pre>";

echo "<h3>Mage</h3>";
echo "<pre>";
UtilityController::afficherPersonnage($mage);
echo "</pre>";

echo "<h3>Archer</h3>";
echo "<pre>";
UtilityController::afficherPersonnage($archer);
echo "</pre>";

// Démonstration de la surcharge de méthodes avec le Guerrier
echo "<h2>Démonstration de la surcharge de méthodes (Guerrier)</h2>";
echo "<pre>";
$guerrier->attaquer($mage); // Utilisation de la première surcharge
$guerrier->attaquerAvecPuissance($mage, 2); // Utilisation de la deuxième surcharge
$guerrier->attaquerAvecArme($mage, "une hache"); // Utilisation de la troisième surcharge
echo "</pre>";

// Démonstration du polymorphisme
echo "<h2>Démonstration du polymorphisme</h2>";
echo "<pre>";
$personnages = [$guerrier, $mage, $archer];

foreach ($personnages as $personnage) {
    // Polymorphisme: la méthode attaquer() est différente selon le type de personnage
    $personnage->attaquer($guerrier);
}
echo "</pre>";

// Démonstration de l'utilisation d'interface
echo "<h2>Démonstration de l'utilisation d'interface</h2>";
echo "<pre>";
// L'archer implémente l'interface Combatant
$archer->combattre($mage);
echo "</pre>";

// Lien vers le formulaire de création de personnage
echo "<p><a href='views/personnage_form.php'>Créer un nouveau personnage</a></p>";