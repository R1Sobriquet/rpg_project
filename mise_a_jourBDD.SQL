-- Création de la table type_classe
CREATE TABLE IF NOT EXISTS type_classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    force_base INT NOT NULL,
    agilite_base INT NOT NULL,
    intelligence_base INT NOT NULL,
    points_de_vie_base INT NOT NULL,
    points_de_magie_base INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion des types de classe par défaut
INSERT INTO type_classe (nom, description, force_base, agilite_base, intelligence_base, points_de_vie_base, points_de_magie_base) VALUES
('Guerrier', 'Un combattant puissant spécialisé dans les attaques au corps à corps', 70, 50, 30, 200, 50),
('Mage', 'Un lanceur de sorts maîtrisant les arcanes de la magie', 30, 40, 80, 100, 200),
('Archer', 'Un combattant agile spécialisé dans les attaques à distance', 50, 75, 50, 150, 80);

-- Modification de la table personnages
ALTER TABLE personnages 
    ADD COLUMN type_classe_id INT,
    ADD FOREIGN KEY (type_classe_id) REFERENCES type_classe(id) ON DELETE SET NULL;

-- Mise à jour des personnages existants (si nécessaire)
UPDATE personnages SET type_classe_id = (SELECT id FROM type_classe WHERE nom = classe) WHERE type_classe_id IS NULL;

-- Une fois toutes les données migrées, vous pouvez supprimer la colonne classe si vous le souhaitez
-- ALTER TABLE personnages DROP COLUMN classe;