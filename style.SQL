REATE DATABASE gestion_reservations;

USE gestion_reservations;

CREATE TABLE utilisateurs (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    prenom VARCHAR(100) NOT NULL,

    email VARCHAR(100) UNIQUE NOT NULL,

    mot_de_passe VARCHAR(255) NOT NULL,

    role ENUM('utilisateur', 'administrateur') DEFAULT 'utilisateur'

);

CREATE TABLE salles (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    capacite INT NOT NULL,

    description TEXT

);

CREATE TABLE reservations (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT,

    salle_id INT,

    date_reservation DATETIME NOT NULL,

    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,

    FOREIGN KEY (salle_id) REFERENCES salles(id) ON DELETE CASCADE

);

SELECT * FROM reservations 

WHERE salle_id = ? AND date_reservation = ?;

INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) 

VALUES 

('Dupont', 'Pierre', 'pierre.dupont@example.com', 'motdepasse123', 'utilisateur'),

('Martin', 'Julie', 'julie.martin@example.com', 'motdepasse456', 'administrateur');

INSERT INTO salles (nom, capacite, description) 

VALUES 

('Salle A', 20, 'Salle de réunion équipée de projecteur et tableau blanc'),

('Salle B', 10, 'Petite salle pour des réunions privées');

INSERT INTO reservations (utilisateur_id, salle_id, date_reservation) 

VALUES 

(1, 1, '2024-11-25 14:00:00'),

(2, 2, '2024-11-25 15:00:00');

SELECT * FROM reservations 

WHERE salle_id = ? AND date_reservation = ?;

UPDATE reservations

SET salle_id = ?, date_reservation = ?

WHERE id = ?;

DELETE FROM reservations WHERE id = ?;


-- Créer la base de données

CREATE DATABASE gestion_reservations;

USE gestion_reservations;



-- Créer la table des utilisateurs

CREATE TABLE utilisateurs (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    prenom VARCHAR(100) NOT NULL,

    email VARCHAR(100) UNIQUE NOT NULL,

    mot_de_passe VARCHAR(255) NOT NULL,

    role ENUM('utilisateur', 'administrateur') DEFAULT 'utilisateur'

);



-- Créer la table des salles

CREATE TABLE salles (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    capacite INT NOT NULL,

    description TEXT

);



-- Créer la table des réservations

CREATE TABLE reservations (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT,

    salle_id INT,

    date_reservation DATETIME NOT NULL,

    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,

    FOREIGN KEY (salle_id) REFERENCES salles(id) ON DELETE CASCADE

);



-- Insérer des données d'exemple dans utilisateurs

INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) 

VALUES 

('Dupont', 'Pierre', 'pierre.dupont@example.com', 'motdepasse123', 'utilisateur'),

('Martin', 'Julie', 'julie.martin@example.com', 'motdepasse456', 'administrateur');



-- Insérer des données d'exemple dans salles

INSERT INTO salles (nom, capacite, description) 

VALUES 

('Salle A', 20, 'Salle de réunion équipée de projecteur et tableau blanc'),

('Salle B', 10, 'Petite salle pour des réunions privées');



-- Insérer des réservations d'exemple

INSERT INTO reservations (utilisateur_id, salle_id, date_reservation) 

VALUES 

(1, 1, '2024-11-25 14:00:00'),

(2, 2, '2024-11-25 15:00:00');



