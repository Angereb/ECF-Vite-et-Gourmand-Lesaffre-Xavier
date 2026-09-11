# Vite & Gourmand

Site web pour le traiteur événementiel fictif "Vite & Gourmand" (Bordeaux) — projet réalisé dans le cadre de l'ECF (Évaluation en Cours de Formation) du TP Développeur Web et Web Mobile Full Stack.

## Contexte

Application web permettant :
- Aux visiteurs de découvrir l'entreprise et ses menus
- Aux clients de commander des prestations, gérer leur compte, suivre leurs commandes et laisser des avis
- Aux employés de gérer les commandes, avis, horaires et menus
- Aux administrateurs de gérer les comptes employés et consulter des statistiques de vente

## Stack technique

- **Back-end** : PHP 8.2 / PDO / MySQL
- **NoSQL** : MongoDB (statistiques de vente)
- **Front-end** : HTML / CSS / JavaScript (vanilla, AJAX)
- **Dépendances** : PHPMailer (envoi de mails), mongodb/mongodb (via Composer)
- **Outils** : XAMPP (environnement local), Figma (maquettage), draw.io (diagrammes), QuickDBD (diagramme relationnel)

## Installation locale

### Prérequis
- XAMPP (PHP 8.2+, MySQL, Apache)
- Composer
- MongoDB Community Server (pour les statistiques admin)

### Étapes

1. Cloner le dépôt dans le dossier `htdocs` de XAMPP
2. Installer les dépendances : `composer install`
3. Copier `Site/Configuration/config.example.php` vers `Site/Configuration/config.php`, et renseigner les accès à la base de données, au serveur SMTP et à MongoDB
4. Créer la base de données MySQL en exécutant le script `Documentation/schema.sql` (à adapter selon l'emplacement réel de ton fichier)
5. Peupler les données de référence indispensables (statuts, régimes, matériels, comptes administrateurs) via les scripts du dossier `Site/Donnees/` (non versionné, à créer localement)
6. Lancer Apache et MySQL depuis XAMPP, accéder au site via `http://localhost/nom-du-dossier`

## Documentation

La documentation technique complète (MCD, diagrammes, prototypes Figma) se trouve dans le dossier `Documentations/`.

## Déploiement

Le site est déployé sur Heroku : [lien à ajouter une fois déployé]

## Auteur

Lesaffre Xavier — TP Développeur Web et Web Mobile (Studi)