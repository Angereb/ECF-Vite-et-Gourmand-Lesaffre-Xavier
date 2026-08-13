CREATE TABLE commandesPlats(
    commandesId BIGINT,
    platsId BIGINT,
    PRIMARY KEY (commandesId, platsId),
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (platsId)
        REFERENCES plats(platsId)
);