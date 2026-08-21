CREATE TABLE plats(
    platsId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL UNIQUE,
    categorie VARCHAR(32) NOT NULL,
    photo BLOB,
    actif BOOLEAN DEFAULT TRUE,
    regimesId BIGINT NOT NULL,
    FOREIGN KEY (regimesId)
        REFERENCES regimes(regimesId)
);