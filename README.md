# Projet RPG - Système de Gestion des Personnages

## Contexte
Ce projet a pour objectif de créer un système de gestion des personnages pour un nouveau jeu de rôle (RPG). Les joueurs doivent pouvoir créer et gérer leurs personnages, qui possèdent différentes caractéristiques et capacités.

## Caractéristiques des Personnages
Chaque personnage a les attributs suivants :
- **Nom** (public) : Le nom du personnage.
- **Genre** (public) : Indique si le personnage est un homme ou une femme.
- **Classe** (public) : Type de personnage (Guerrier, Mage, Archer).
- **Force** (private) : Représente la force du personnage.
- **Agilité** (private) : Représente l'agilité du personnage.
- **Intelligence** (private) : Représente l'intelligence du personnage.
- **Points de Vie** (private) : Représente la santé du personnage.
- **Points de Magie** (private) : Représente les ressources magiques du personnage.

## Concepts de Programmation Orientée Objet
Ce projet intègre des concepts avancés de POO, tels que :
- **Classes abstraites** : Utilisées pour définir des comportements communs pour les classes dérivées.
- **Surcharge** : Permet d'utiliser plusieurs méthodes avec le même nom mais des signatures différentes.
- **Polymorphisme** : Permet d'utiliser des objets de différentes classes de manière interchangeable.
- **Méthodes statiques** : Utilisées pour des opérations qui ne dépendent pas d'une instance de la classe.
- **Interfaces** : Définissent des méthodes que les classes doivent implémenter.

## Interface Web
Une interface web est créée pour permettre aux utilisateurs de saisir les informations des personnages et de les enregistrer dans une base de données. Cette interface utilise des requêtes et des méthodes de communication avec la base de données qui implémentent également la POO.

## Structure du Projet
```
/rpg_project
    /config
        database.php           - Configuration de la connexion à la base de données
    /src
        /Entity
            Personnage.php     - Classe abstraite de base pour tous les personnages
            Guerrier.php       - Classe héritant de Personnage pour les guerriers
            Mage.php           - Classe héritant de Personnage pour les mages
            Archer.php         - Classe héritant de Personnage et implémentant Combatant
        /Controller
            PersonnageController.php - Gère les interactions entre le modèle et la vue
        /Model
            PersonnageModel.php - Gère les opérations CRUD pour les personnages
        /Interface
            Combatant.php       - Interface pour les personnages pouvant combattre
        /Utilitaire
            Utilitaire.php      - Classe contenant des méthodes statiques utilitaires
    /views
        /partials
            header.php          - En-tête HTML commun
            footer.php          - Pied de page HTML commun
        personnage_form.php     - Formulaire de création/modification de personnage
    /public
        /assets
            /images             - Images pour l'interface
        style.css               - Feuille de style CSS
        main.js                 - Script JavaScript pour les interactions
    index.php                   - Page d'accueil
    README.md                   - Documentation du projet
```

## Prérequis
- PHP 7.4 ou supérieur
- Serveur web (Apache, Nginx, etc.)
- MySQL ou MariaDB

## Installation
1. Clonez ce dépôt dans votre répertoire web :
   ```
   git clone https://github.com/votre-username/rpg_project.git
   ```

2. Importez la base de données :
   ```sql
   -- Création de la base de données
CREATE DATABASE IF NOT EXISTS rpg_database;
USE rpg_database;

-- Table type_classe
CREATE TABLE IF NOT EXISTS type_classe (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    description TEXT NULL,
    force_base INT,
    agilite_base INT,
    intelligence_base INT,
    points_de_magie_base INT,
    points_de_vie_base INT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table personnages
CREATE TABLE IF NOT EXISTS personnages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    genre VARCHAR(50),
    classe VARCHAR(255),
    force INT,
    agilite INT,
    intelligence INT,
    points_de_magie INT,
    points_de_vie INT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    type_classe_id INT NULL,
    FOREIGN KEY (type_classe_id) REFERENCES type_classe(id)
);
   ```

3. Configurez la connexion à la base de données :
   - Modifiez le fichier `config/database.php` avec vos identifiants de connexion.

4. Assurez-vous que les répertoires suivants ont les permissions d'écriture :
   - `/public/assets/images`

5. Accédez à l'application via votre navigateur :
   ```
   http://localhost/rpg_project/
   ```

## Fonctionnalités
- **Création de personnages** : Créez des personnages avec différentes classes et attributs.
- **Gestion des personnages** : Modifiez et supprimez vos personnages existants.
- **Polymorphisme** : Visualisez la démonstration du polymorphisme avec les différentes attaques.
- **Interface responsive** : Profitez d'une interface adaptée à tous les appareils.

## Classes et Architecture

### Classe Abstraite Personnage
Cette classe sert de base pour tous les types de personnages. Elle définit :
- Les attributs communs (nom, genre, force, etc.)
- Les getters et setters
- La méthode abstraite `attaquer()`

### Classes Dérivées
- **Guerrier** : Spécialisé dans les attaques physiques avec surcharge de méthodes.
- **Mage** : Spécialisé dans les attaques magiques utilisant l'intelligence.
- **Archer** : Spécialisé dans les attaques à distance utilisant l'agilité et implémentant l'interface Combatant.

### Interface Combatant
Définit le comportement des personnages pouvant engager un combat avec la méthode `combattre()`.

### Architecture MVC
Le projet suit une architecture Modèle-Vue-Contrôleur (MVC) :
- **Modèle** (PersonnageModel) : Gère l'accès aux données et les opérations CRUD.
- **Vue** (fichiers PHP dans /views) : Gère l'affichage et l'interface utilisateur.
- **Contrôleur** (PersonnageController) : Gère la logique métier et les interactions.

## Sécurité
- Utilisation de requêtes préparées pour éviter les injections SQL.
- Validation des données côté serveur.
- Échappement des sorties HTML pour prévenir les attaques XSS.

## Améliorations futures
- Système d'authentification des utilisateurs
- Système de combat entre personnages
- Système d'équipements et d'inventaire
- Système de progression et de niveaux
- Système de quêtes et de missions

## Auteur
[Votre Nom] - [Votre Email]

## Licence
Ce projet est sous licence MIT - voir le fichier LICENSE pour plus de détails.
