CREATE TABLE horaires(
    horairesId BIGINT PRIMARY KEY AUTO_INCREMENT,
    jour VARCHAR(16) NOT NULL UNIQUE,
    heuresOuverture TIME,
    heuresFermeture TIME
);