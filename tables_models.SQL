-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    date_inscription DATETIME NOT NULL,
    dernier_login DATETIME NOT NULL
);

-- Table des équipes
CREATE TABLE IF NOT EXISTS equipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table de liaison entre personnages et équipes
CREATE TABLE IF NOT EXISTS equipe_personnage (
    equipe_id INT NOT NULL,
    personnage_id INT NOT NULL,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (equipe_id, personnage_id),
    FOREIGN KEY (equipe_id) REFERENCES equipes(id) ON DELETE CASCADE,
    FOREIGN KEY (personnage_id) REFERENCES personnages(id) ON DELETE CASCADE
);

-- Table des profils de personnages
CREATE TABLE IF NOT EXISTS profils (
    id INT AUTO_INCREMENT PRIMARY KEY,
    personnage_id INT NOT NULL UNIQUE,
    niveau INT NOT NULL DEFAULT 1,
    experience INT NOT NULL DEFAULT 0,
    FOREIGN KEY (personnage_id) REFERENCES personnages(id) ON DELETE CASCADE
);

-- Table des compétences
CREATE TABLE IF NOT EXISTS competences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    classe VARCHAR(30) NOT NULL -- Pour associer la compétence à une classe de personnage
);

-- Table de liaison entre profils et compétences
CREATE TABLE IF NOT EXISTS profil_competence (
    profil_id INT NOT NULL,
    competence_id INT NOT NULL,
    date_acquisition TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (profil_id, competence_id),
    FOREIGN KEY (profil_id) REFERENCES profils(id) ON DELETE CASCADE,
    FOREIGN KEY (competence_id) REFERENCES competences(id) ON DELETE CASCADE
);

-- Table des équipements
CREATE TABLE IF NOT EXISTS equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    type VARCHAR(30) NOT NULL, -- Type d'équipement (arme, armure, etc.)
    bonus_force INT DEFAULT 0,
    bonus_agilite INT DEFAULT 0,
    bonus_intelligence INT DEFAULT 0
);

-- Table de liaison entre profils et équipements
CREATE TABLE IF NOT EXISTS profil_equipement (
    profil_id INT NOT NULL,
    equipement_id INT NOT NULL,
    equipe BOOLEAN DEFAULT FALSE, -- Indique si l'équipement est équipé ou dans l'inventaire
    PRIMARY KEY (profil_id, equipement_id),
    FOREIGN KEY (profil_id) REFERENCES profils(id) ON DELETE CASCADE,
    FOREIGN KEY (equipement_id) REFERENCES equipements(id) ON DELETE CASCADE
);

-- Ajout de la relation entre personnages et utilisateurs
ALTER TABLE personnages 
ADD COLUMN utilisateur_id INT,
ADD FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL;