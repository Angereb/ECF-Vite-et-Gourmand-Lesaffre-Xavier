CREATE DATABASE vite_et_gourmand;

USE vite_et_gourmand;

CREATE TABLE themes(
    themesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL UNIQUE
);

CREATE TABLE regimes(
    regimesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE allergenes(
    allergenesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE statutsCommande(
    statutsCommandeId BIGINT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE statutsAvis(
    statutsAvisId BIGINT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE materiels(
    materielsId BIGINT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE horaires(
    horairesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    jour VARCHAR(16) NOT NULL UNIQUE,
    heuresOuverture TIME,
    heuresFermeture TIME
);

CREATE TABLE utilisateurs(
    utilisateursId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(64) NOT NULL,
    prenom VARCHAR(64) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
    motDePasse VARCHAR(128) NOT NULL
);

CREATE TABLE menus(
    menusId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL,
    conditions TEXT,
    minimumConvive INT NOT NULL,
    stock INT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    themesId BIGINT NOT NULL,
    regimesid BIGINT NOT NULL,
    FOREIGN KEY (themesId)
        REFERENCES themes(themesId),
    FOREIGN KEY (regimesId)
        REFERENCES regimes(regimesId)
);

CREATE TABLE plats(
    platsId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL UNIQUE,
    categorie VARCHAR(32) NOT NULL,
    photo BLOB,
    regimesId BIGINT NOT NULL,
    FOREIGN KEY (regimesId)
        REFERENCES regimes(regimesId)
);

CREATE TABLE clients(
    utilisateursId BIGINT PRIMARY KEY,
    numeroTelephone VARCHAR(16) NOT NULL,
    adressePostale TEXT NOT NULL,
    FOREIGN KEY (utilisateursId)
        REFERENCES utilisateurs(utilisateursId)
);

CREATE TABLE employes(
    utilisateursId BIGINT PRIMARY KEY,
    administrateur BOOLEAN NOT NULL,
    actif BOOLEAN NOT NULL,
    FOREIGN KEY (utilisateursId)
        REFERENCES utilisateurs(utilisateursId)
);

CREATE TABLE images(
    imagesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL,
    photo BLOB NOT NULL,
    menusId BIGINT NOT NULL,
    FOREIGN KEY (menusId)
        REFERENCES menus(menusId)
);

CREATE TABLE commandes(
    commandesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    adresse TEXT NOT NULL,
    datePrestation DATE NOT NULL,
    heureLivraison TIME NOT NULL,
    convive INT NOT NULL,
    facture DECIMAL(10, 2) NOT NULL,
    utilisateursId BIGINT NOT NULL,
    menusId BIGINT NOT NULL,
    statutsCommandeId BIGINT NOT NULL,
    FOREIGN KEY (utilisateursId)
        REFERENCES clients(utilisateursId),
    FOREIGN KEY (menusId)
        REFERENCES menus(menusId),
    FOREIGN KEY (statutsCommandeId)
        REFERENCES statutsCommande(statutsCommandeId)
);

CREATE TABLE avis(
    avisId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(68) NOT NULL,
    note TINYINT NOT NULL,
    commentaire TEXT NOT NULL,
    commandesId BIGINT NOT NULL UNIQUE,
    statutsAvisId BIGINT NOT NULL,
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (statutsAvisId)
        REFERENCES statutsAvis(statutsAvisId)
);

CREATE TABLE menusPlats(
    menusId BIGINT,
    platsId BIGINT,
    PRIMARY KEY (menusId, platsId),
    FOREIGN KEY (menusId)
        REFERENCES menus(menusId),
    FOREIGN KEY (platsId)
        REFERENCES plats(platsId)
);

CREATE TABLE platsAllergenes(
    platsId BIGINT,
    allergenesId BIGINT,
    PRIMARY KEY (platsId, allergenesId),
    FOREIGN KEY (platsId)
        REFERENCES plats(platsId),
    FOREIGN KEY (allergenesId)
        REFERENCES allergenes(allergenesId)
);

CREATE TABLE commandesPlats(
    commandesId BIGINT,
    platsId BIGINT,
    PRIMARY KEY (commandesId, platsId),
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (platsId)
        REFERENCES plats(platsId)
);

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

CREATE TABLE historiquesStatutsCommandes(
    historiquesStatutsCommandesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    dateModification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    motif TEXT NOT NULL,
    modeContact VARCHAR(32) NOT NULL,
    commandesId BIGINT NOT NULL,
    statutsCommandeId BIGINT NOT NULL,
    FOREIGN KEY (commandesId)
        REFERENCES commandes(commandesId),
    FOREIGN KEY (statutsCommandeId)
        REFERENCES statutsCommande(statutsCommandeId)
);