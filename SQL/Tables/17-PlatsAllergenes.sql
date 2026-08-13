CREATE TABLE platsAllergenes(
    platsId BIGINT,
    allergenesId BIGINT,
    PRIMARY KEY (platsId, allergenesId),
    FOREIGN KEY (platsId)
        REFERENCES plats(platsId),
    FOREIGN KEY (allergenesId)
        REFERENCES allergenes(allergenesId)
);