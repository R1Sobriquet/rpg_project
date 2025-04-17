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
