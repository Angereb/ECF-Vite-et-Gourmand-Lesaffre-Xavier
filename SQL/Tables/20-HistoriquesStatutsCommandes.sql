CREATE TABLE historiquesStatutsCommandes(
    historiquesStatutsCommandesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    dateModification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    motif TEXT,
    modeContact VARCHAR(32),
    commandesId BIGINT NOT NULL,
    statutsCommandeId BIGINT NOT NULL,
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (statutsCommandeId)
        REFERENCES statutsCommande(statutsCommandeId)
);