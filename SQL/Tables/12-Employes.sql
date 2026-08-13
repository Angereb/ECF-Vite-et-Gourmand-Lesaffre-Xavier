CREATE TABLE employes(
    utilisateursId BIGINT PRIMARY KEY,
    administrateur BOOLEAN NOT NULL,
    actif BOOLEAN NOT NULL,
    FOREIGN KEY (utilisateursId)
        REFERENCES utilisateurs(utilisateursId)
);