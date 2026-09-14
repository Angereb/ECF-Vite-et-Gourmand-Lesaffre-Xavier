INSERT INTO `utilisateurs` (`utilisateursId`, `nom`, `prenom`, `email`, `motDePasse`) VALUES
(1, 'Gourmand', 'José', 'jose.gourmand@viteetgourmand.com', '$2y$10$ZJNh26Eu6jpEru2eOlqFrOoR14rSekBufJReVtE2bquuznEzih766'),
(2, 'Gourmand', 'Julie', 'julie.gourmand@viteetgourmand.com', '$2y$10$GgkqWFBiyItAWEoXpIzqgOvbOCsr9fB6TK8cd7M4YKf7IeJDPZZYG');

INSERT INTO `employes` (`utilisateursId`, `administrateur`, `actif`) VALUES
(1, 1, 1),
(2, 1, 1);

INSERT INTO `materiels` (`materielsId`, `libelle`) VALUES
(7, 'Barbecue'),
(9, 'Chauffe-plat'),
(4, 'Grand congélateur'),
(2, 'Grand frigo'),
(5, 'Gril'),
(3, 'Petit congélateur'),
(1, 'Petit frigo'),
(8, 'Plaque cuisson'),
(6, 'Rôtissoire');

INSERT INTO `regimes` (`regimesId`, `libelle`) VALUES
(1, 'Classique'),
(3, 'Vegan'),
(2, 'Végétarien');

INSERT INTO `statutsAvis` (`statutsAvisId`, `libelle`) VALUES
(1, 'En attente'),
(3, 'Refuser'),
(2, 'Valider');

INSERT INTO `statutsCommande` (`statutsCommandeId`, `libelle`) VALUES
(2, 'Accepté'),
(7, 'Annulée'),
(1, 'En attente'),
(5, 'En attente retour matériel'),
(3, 'En préparation'),
(4, 'Livré'),
(6, 'Terminée');