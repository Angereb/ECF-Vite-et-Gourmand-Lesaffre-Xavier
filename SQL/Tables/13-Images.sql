CREATE TABLE images(
    imagesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL,
    photo BLOB NOT NULL,
    menusId BIGINT NOT NULL,
    FOREIGN KEY (menusId)
        REFERENCES menus(menusId)
);