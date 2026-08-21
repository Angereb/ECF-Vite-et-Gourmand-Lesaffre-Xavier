CREATE TABLE menus(
    menusId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL,
    conditions TEXT,
    minimumConvive INT NOT NULL,
    stock INT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    themesId BIGINT NOT NULL,
    regimesId BIGINT NOT NULL,
    FOREIGN KEY (themesId)
        REFERENCES themes(themesId),
    FOREIGN KEY (regimesId)
        REFERENCES regimes(regimesId)
);