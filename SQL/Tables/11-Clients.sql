CREATE TABLE clients(
    utilisateursId BIGINT PRIMARY KEY,
    numeroTelephone VARCHAR(16) NOT NULL,
    adressePostale TEXT NOT NULL,
    FOREIGN KEY (utilisateursId)
        REFERENCES utilisateurs(utilisateursId)
);