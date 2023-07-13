-- Ajout de données dans la bd stampee

-- utilisateur
INSERT INTO utilisateur (utilisateur_id, utilisateur_prenom, utilisateur_nom, utilisateur_pseudo, utilisateur_courriel, utilisateur_mdp,utilisateur_profil) VALUES
(1, 'Prénom 1', 'Nom 1', 'Pseudo1', 'prenom1.nom1@test.com', SHA2('motdepasse1', 512), 'client'),
(2, 'Prénom 2', 'Nom 2', 'Pseudo2', 'prenom2.nom2@test.com', SHA2('motdepasse2', 512), 'client'),
(3, 'Prénom 3', 'Nom 3', 'Pseudo3', 'prenom3.nom3@test.com', SHA2('motdepasse3', 512), 'client'),
(4, 'Prénom 4', 'Nom 4', 'Pseudo4', 'prenom4.nom4@test.com', SHA2('motdepasse4', 512), 'client'),
(5, 'Prénom 5', 'Nom 5', 'Pseudo5', 'prenom5.nom5@test.com', SHA2('motdepasse5', 512), 'client'),
(6, 'Prénom 6', 'Nom 6', 'Pseudo6', 'prenom6.nom6@test.com', SHA2('motdepasse6', 512), 'client'),
(7, 'Prénom 7', 'Nom 7', 'Pseudo7', 'prenom7.nom7@test.com', SHA2('motdepasse7', 512), 'client'),
(8, 'Prénom 8', 'Nom 8', 'Pseudo8', 'prenom8.nom8@test.com', SHA2('motdepasse8', 512), 'client'),
(9, 'Prénom 9', 'Nom 9', 'Pseudo9', 'prenom9.nom9@test.com', SHA2('motdepasse9', 512), 'client'),
(10, 'Prénom 10', 'Nom 10', 'Pseudo10', 'prenom10.nom10@test.com', SHA2('motdepasse10', 512), 'client');


-- timbre
INSERT INTO timbre (timbre_id, timbre_nom, timbre_date_creation, timbre_pays_origine, timbre_image_principale, timbre_condition, timbre_tirage, timbre_longueur, timbre_largeur, timbre_certifie, timbre_description, timbre_couleur, id_utilisateur) VALUES
(1, 'Nom 1', '2022-01-01', 'Pays 1', '1', 'parfaite', 1000, 2.5, 3.5, 1, 'Description 1', 'Rouge', 1),
(2, 'Nom 2', '2022-02-01', 'Pays 2', '2', 'excellente', 2000, 3.5, 4.5, 0, 'Description 2', 'Bleu', 2),
(3, 'Nom 3', '2022-03-01', 'Pays 3', '3', 'bonne', 3000, 4.5, 5.5, 1, 'Description 3', 'Orange', 3),
(4, 'Nom 4', '2022-04-01', 'Pays 4', '4', 'moyenne', 4000, 5.5, 6.5, 0, 'Description 4', 'Jaune', 4),
(5, 'Nom 5', '2022-05-01', 'Pays 5', '5', 'endommagé', 5000, 6.5, 7.5, 1, 'Description 5', 'Vert', 5),
(6, 'Nom 6', '2022-06-01', 'Pays 6', '6', 'parfaite', 6000, 7.5, 8.5, 0, 'Description 6', 'Rose', 6),
(7, 'Nom 7', '2022-07-01', 'Pays 7', '7', 'excellente', 7000, 8.5, 9.5, 1, 'Description 7', 'Mauve', 7),
(8, 'Nom 8', '2022-08-01', 'Pays 8', '8', 'bonne', 8000, 9.5, 10.5, 0, 'Description 8', 'Noir/Blanc', 8),
(9, 'Nom 9', '2022-09-01', 'Pays 9', '9', 'moyenne', 9000, 10.5, 11.5, 1, 'Description 9', 'Gris', 9),
(10, 'Nom 10', '2022-10-01', 'Pays 10', '10', 'endommagé', 10000, 11.5, 12.5, 0, 'Description 10', 'Argent', 10);

-- image
INSERT INTO image (image_id, id_timbre, image_fichier) VALUES
(NULL, 1, 'image1_1'),
(NULL, 1, 'image1_2'),
(NULL, 2, 'image2_1'),
(NULL, 2, 'image2_2'),
(NULL, 3, 'image3_1'),
(NULL, 3, 'image3_2'),
(NULL, 4, 'image4_1'),
(NULL, 4, 'image4_2'),
(NULL, 5, 'image5_1'),
(NULL, 5, 'image5_2');

-- enchere
INSERT INTO enchere (enchere_id, id_vendeur, id_timbre, enchere_date_debut, enchere_date_fin,enchere_cdc_lord, enchere_prix_plancher) VALUES
(1, 1, 1, '2022-07-08 09:00:00', '2023-07-08 18:00:00', 0, 10.00),
(2, 2, 2, '2022-07-08 09:00:00', '2023-07-22 18:00:00', 0, 20.00),
(3, 3, 3, '2022-07-08 09:00:00', '2023-07-23 18:00:00', 0, 30.00),
(4, 4, 4, '2022-07-08 09:00:00', '2023-07-24 18:00:00', 0, 40.00),
(5, 5, 5, '2022-07-08 09:00:00', '2023-07-25 18:00:00', 0, 50.00),
(6, 6, 6, '2022-07-08 09:00:00', '2023-07-26 18:00:00', 0, 60.00),
(7, 7, 7, '2022-07-08 09:00:00', '2023-07-27 18:00:00', 0, 70.00),
(8, 8, 8, '2022-07-08 09:00:00', '2023-07-28 18:00:00', 0, 80.00),
(9, 9, 9, '2022-07-08 09:00:00', '2023-07-29 18:00:00', 0, 90.00),
(10, 10, 10, '2022-07-08 09:00:00', '2023-07-30 18:00:00', 0, 100.00);

-- mise
INSERT INTO mise (mise_id, id_utilisateur, id_enchere, mise_montant, mise_date) VALUES
(NULL, 1, 9, 15.00, '2022-06-01 10:00:00'),
(NULL, 1, 2, 20.00, '2022-06-01 10:05:00'),
(NULL, 1, 3, 25.00, '2022-06-01 10:10:00'),
(NULL, 2, 4, 30.00, '2022-06-02 10:00:00'),
(NULL, 2, 5, 35.00, '2022-06-02 10:05:00'),
(NULL, 3, 6, 40.00, '2022-06-03 10:00:00'),
(NULL, 4, 7, 45.00, '2022-06-04 10:00:00'),
(NULL, 5, 8, 50.00, '2022-06-05 10:00:00'),
(NULL, 6, 9, 55.00, '2022-06-06 10:00:00'),
(NULL, 7, 10, 60.00, '2022-06-07 10:00:00');

-- favori
INSERT INTO favori (favori_id, id_utilisateur, id_enchere, favori_date) VALUES
(NULL, 1, 1, '2022-06-01'),
(NULL, 2, 2, '2022-06-02'),
(NULL, 3, 3, '2022-06-03'),
(NULL, 4, 4, '2022-06-04'),
(NULL, 5, 5, '2022-06-05'),
(NULL, 6, 6, '2022-06-06'),
(NULL, 7, 7, '2022-06-07'),
(NULL, 8, 8, '2022-06-08'),
(NULL, 9, 9, '2022-06-09'),
(NULL, 10, 10, '2022-06-10');



