# Ecoride - Plateforme de Covoiturage

## Description

Cette application de covoiturage permet aux utilisateurs de rechercher et réserver des trajets en toute simplicité. Les conducteurs peuvent proposer leurs trajets, et les passagers peuvent réserver une place en fonction de leurs besoins. L'objectif est de faciliter le partage de trajets tout en optimisant les coûts et en réduisant l'empreinte carbone.

## Technologies utilisées

### Frontend

- Bootstrap & SASS : Design responsive et moderne avec une meilleure gestion des styles.
- Twig : Moteur de template rapide et sécurisé intégré à Symfony.

### Backend

- Symfony (dernière version) : Framework robuste pour une architecture évolutive et sécurisée.
- Doctrine ORM : Gestion des bases de données relationnelles avec MySQL.

### Base de Données

- MySQL : Système de gestion de base de données relationnelle performant.
- Adminer : Interface simple pour gérer MySQL facilement.

### Sécurité

- JWT (JSON Web Token) : Authentification sécurisée sans stockage de session côté serveur.
- SSL : Chiffrement des communications pour protéger les données des utilisateurs.

### Hébergement & Déploiement

- Heroku : Hébergement cloud avec gestion simplifiée des déploiements.

### Monitoring

- Prometheus & Grafana : Surveillance des performances et affichage des métriques système.

## Installation & Configuration


### 1. Installer les technologies 
- git
- composer
- node.js
- npm
- symfony cli

### 2. Créer le projet symfony et installer les dépendances

- composer create-project symfony/skeleton EcoRide
- cd EcoRide
- composer require webapp
- composer require doctrine
- composer require symfony/orm-pack
- composer require symfony/maker-bundle
- composer require symfony/security-bundle
- composer require symfony/webapp-encore-bundle

- npm install bootstrap sass

### 3. Téléchargement Adminer.php

- télécharger le fichier et le placer dans le dossier public du projet.


### 4️. Créer la base de données et exécuter les migrations

- php bin/console doctrine:database:create
- php bin/console make:entity // pour créer les tables de la base de données avec leurs champs correspondants
- php bin/console doctrine:migrations:migrate


### 5. Configuration des variables d'environnement

- le fichier .env doit être en mode dev le temps de préparer le projet. 
- décommenter la ligne qui active mysql, en ajoutant les bons identifiants de la base de données et le port utilisé.

### 6. Usage de Git

- git init
- git remote add origin < url repository >
- git flow init

=> usage de git flow pour faciliter le travail avec les différentes branches: main, develop, feature, hotfix, release


### 7. Lancer le serveur local

- php -S localhost:8000 -t public

L'application sera accessible via http://localhost:8000.

## Fonctionnalités

- Recherche et affichage de trajets
- Réservation de places
- Ajout de trajets pour les conducteurs
- Authentification et gestion des utilisateurs (JWT)
- Notes et avis laissés par les passagers
- Envoi de messages entre utilisateurs
- Tableau de bord administrateur avec statistiques
- Sécurisation avec SSL


## Licence

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, de le modifier et de le partager.