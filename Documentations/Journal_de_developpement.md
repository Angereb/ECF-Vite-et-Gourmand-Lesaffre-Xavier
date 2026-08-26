# Journal de Développement

## Informations

Ce journal de développement a été fait pour suivre le projet Vite et Gourmand demander pour mon ECF dans le cadre de ma formation de développeur web full stack.

## 02 Août 2026 au 04 Août 2026

### Objectifs

- Initialisation du projet

### Réalisations

- Création du Diagramme de cas d'utilisation
- Création du Diagramme de Séquence
- Création du Diagramme de classes
- Création du Diagramme relationnel
- Ouverture du repo git

---

## 05 Août 2026 au 11 Août 2026

### Objectifs

- Prototypage du projet

### Réalisations

- Création de la charte graphique
- Création de wireframes mobile, 2 pour la page d'accueil (normal et menu du site ouvert), 2 pour la page des menus (menus fermer et ouvert), 1 pour la page de commande
- Modification du Diagramme de classes pour inclure une cardinalité entre Commande et Plat
- Création de wireframes desktop, 1 pour la page d'accueil, 2 pour la page de menus (menus fermer et ouvert), 1 pour la page de commande
- Création de mockups correspondant aux wireframe mobile et desktop

### Difficultés

- Manque de photo pour visuel de repas

### Solutions

- Récupération de visuel libre de droit sur le site Unsplash

---

## 12 et 13 Août 2026

### Objectifs

- Création de la base de donnée

### Réalisations

- Création de toutes les tables (20 tables)
- Ajout dans le diagramme relationnel des tables oubliés (Allergènes et PlatsAllergènes)
- Transfert des tables une par une dans phpMyAdmin et documentation des tables éxecuter dans Schema.sql
- Création d'une batterie de test de la banque de donnée
- Transfert des tests et prise de note du résultat en cas d'échec

---

## 14 au 21 Août 2026

### Objectifs

- Création des classes d'objets suivant tables SQL écrites
- Création des classes de modèle CRUD

### Réalisations

- Création dans le dossier Modele du Site des dossiers correspondant au tables
- Création du modèle de connection à la base de donnée
- Création des classes d'objet pour toutes les tables principales
- Modification du SQL tables et schéma pour ajouter un paramètre de soft DELETE sur certaines tables
- Création des classes de Modèle pour toutes les tables (principales et liaisons)
- Retrait de la notion de "NOT NULL" pour le motif et le modeContact dans l'historique des statuts de commandes
- Création et lancement de divers tests pour vérification de certains CRUD

---

## 22 et 23 Août 2026

### Objectifs

- Développement dans une branche dédier des composants généraux du site (Logo, menu, pied de page)

### Réalisations

- Initialisation du routeur index vers la page d'accueil
- Initialisation du contrôleur de la page d'accueil pour inclusion dans un calque principal
- Création du calque principal et du style général associé au site
- Création du header comprenant le logo du site
- Création du menu responsive, avec adaptation entre version desktop (simple barre) et version mobile (menu burger)
- Création du footer comprenant récupération des horaires et modales pour les mentions légales et le conditions générales de vente

---

## 24 au 26 Août 2026

### Objectifs

- Développement de la page d'accueil
- Développement de la page de contact

### Réalisations

- Page d'accueil en 3 zones (Entreprise, Equipe, Avis)
- Récupérations des avis dans la bdd
- Stylisation de la page Accueil par rapport au mockup
- Page de contact avec formulaire de contact
- Création d'une fonction d'envoie de mail lier à phpmailer
- Stylisation de la page Contact
- Ajout d'un composant Toast pour gérer les messages de validation ou d'erreur des formulaires

---