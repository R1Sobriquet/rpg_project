# Projet RPG - Système de Gestion des Personnages
## Contexte
Ce projet a pour objectif de créer un système de gestion des personnages pour un nouveau jeu de rôle (RPG). Les joueurs doivent pouvoir créer et gérer leurs personnages, qui possèdent différentes caractéristiques et capacités.
## Caractéristiques des Personnages
Chaque personnage a les attributs suivants :
- **Pseudo** (public) : Le nom du personnage.
- **Genre** (public, booléen) : Indique si le personnage est un homme ou une femme.
- **Force** (private) : Représente la force du personnage.
- **Agilité** (private) : Représente l'agilité du personnage.
## Concepts de Programmation Orientée Objet
Ce projet intègre des concepts avancés de POO, tels que :
- **Classes abstraites** : Utilisées pour définir des comportements communs pour les classes dérivées.
- **Surcharge** : Permet d'utiliser plusieurs méthodes avec le même nom mais des signatures différentes.
- **Polymorphisme** : Permet d'utiliser des objets de différentes classes de manière interchangeable.
- **Méthodes statiques** : Utilisées pour des opérations qui ne dépendent pas d'une instance de la classe.
- **Interfaces** : Définissent des méthodes que les classes doivent implémenter.
## Interface Web
Une interface web sera créée pour permettre aux utilisateurs de saisir les informations des personnages et de les enregistrer dans une base de données. Cette interface utilisera des requêtes et des méthodes de communication avec la base de données qui implémentent également la POO.
## Prérequis
- PHP 7.4 ou supérieur
- Serveur web (Apache, Nginx, etc.)
- MySQL ou MariaDB
## Sécurité
- Assurez-vous que votre fichier `config.php` est bien protégé et non accessible publiquement.
- Utilisez des requêtes préparées pour éviter les injections SQL.
- Hachez les mots de passe avant de les stocker dans la base de données.
## Fonctionnalités
- Création de personnages
- Gestion des caractéristiques des personnages
- Interface web pour la saisie et l'enregistrement des informations des personnages
