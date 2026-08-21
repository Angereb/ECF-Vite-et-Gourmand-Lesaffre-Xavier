CREATE TABLE clients(
    utilisateursId BIGINT PRIMARY KEY,
    numeroTelephone VARCHAR(16) NOT NULL,
    adressePostale TEXT NOT NULL,
    actif BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (utilisateursId)
        REFERENCES utilisateurs(utilisateursId)
);