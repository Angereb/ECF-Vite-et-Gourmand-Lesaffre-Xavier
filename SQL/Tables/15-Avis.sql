CREATE TABLE avis(
    avisId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(68) NOT NULL,
    note TINYINT NOT NULL,
    commentaire TEXT NOT NULL,
    commandesId BIGINT NOT NULL UNIQUE,
    statutsAvisId BIGINT NOT NULL,
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (statutsAvisId)
        REFERENCES statutsAvis(statutsAvisId)
);