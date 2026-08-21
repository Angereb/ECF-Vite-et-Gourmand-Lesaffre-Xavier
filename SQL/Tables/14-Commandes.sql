CREATE TABLE commandes(
    commandesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    adresse TEXT NOT NULL,
    codePostal VARCHAR(5) NOT NULL,
    datePrestation DATE NOT NULL,
    heureLivraison TIME NOT NULL,
    dateLivraison DATE NOT NULL,
    convive INT NOT NULL,
    facture DECIMAL(10, 2) NOT NULL,
    utilisateursId BIGINT NOT NULL,
    menusId BIGINT NOT NULL,
    statutsCommandeId BIGINT NOT NULL,
    FOREIGN KEY (utilisateursId)
        REFERENCES clients(utilisateursId),
    FOREIGN KEY (menusId)
        REFERENCES menus(menusId),
    FOREIGN KEY (statutsCommandeId)
        REFERENCES statutsCommande(statutsCommandeId)
);