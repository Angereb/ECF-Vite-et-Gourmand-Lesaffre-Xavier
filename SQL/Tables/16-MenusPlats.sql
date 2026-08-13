CREATE TABLE menusPlats(
    menusId BIGINT,
    platsId BIGINT,
    PRIMARY KEY (menusId, platsId),
    FOREIGN KEY (menusId)
        REFERENCES menus(menusId),
    FOREIGN KEY (platsId)
        REFERENCES plats(platsId)
);