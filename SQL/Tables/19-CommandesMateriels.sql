CREATE TABLE commandesMateriels(
    commandesId BIGINT,
    materielsId BIGINT,
    PRIMARY KEY (commandesId, materielsId),
    quantite INT NOT NULL,
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (materielsId)
        REFERENCES materiels(materielsId)
);