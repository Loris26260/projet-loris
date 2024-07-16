# Projet PHP & MySQL

## Prérequis

- Installer XAMPP.
- Avoir un navigateur web.
- Lancer Apache et MySQL.
- Sur le navigateur, utiliser le lien [http://localhost/b1/](http://localhost/b1/).
- Avoir les bases de données (dans les scripts `scriptbase` et `userbase`).
- copier le fichier b1 (décompressé) dans [C:\xampp\htdocs]

## Introduction

Ce projet est une application web de gestion de produits de pharmacie, développée en PHP et MySQL. L'application permet de se connecter, de créer des comptes utilisateurs et de gérer les produits via une interface graphique.

## Fonctionnalités

### Page de Connexion (`index.php`)

- La page de connexion permet aux utilisateurs de se connecter.
- L'utilisateur par défaut est `admin` avec le mot de passe `password123`.
- La page offre également la possibilité de créer un nouveau compte via la page `inscription.php`.

### Création de Compte (`inscription.php`)

- Les nouveaux utilisateurs peuvent créer un compte.
- **Note importante** : Actuellement, aucune sécurité n'est implémentée pour la création de compte. Les sessions utilisateur sont temporaires et sont supprimées lors de la déconnexion, sans vérification lors de la création du compte.

### Page d'Accueil (`home.php`)

- Cette page contient plusieurs boutons, dont seuls les boutons "Gestion" et "Déconnexion" sont fonctionnels pour l'instant.
- **Améliorations futures** :
  - Créer une page d'accueil pour permettre aux utilisateurs de voir les produits disponibles.
  - Ajouter un bouton "Profil" permettant aux utilisateurs de modifier leur profil (adresse e-mail, mot de passe, etc.).
  - Implémenter un onglet "Paramètres" pour gérer diverses configurations, voir les cookies utilisés par le site, etc. (Actuellement, le bouton "Paramètres" n'est pas utilisable).

### Gestion des Produits (`gestion.php`)

- Permet d'interagir avec la base de données via une interface graphique.
- Options disponibles :
  - Ajouter un nouveau produit.
  - Modifier la quantité d'un produit existant.
  - Supprimer un produit.
- **ProductManager.php** :
  - Ce fichier contient les méthodes nécessaires pour interagir avec la base de données.
  - Il assure le bon fonctionnement de la page de gestion.

## Structure du Projet

- `index.php` : Page de connexion.
- `inscription.php` : Page de création de compte.
- `home.php` : Page d'accueil après connexion.
- `gestion.php` : Interface de gestion des produits.
- `ProductManager.php` : Classe pour gérer les interactions avec la base de données.
- `Product_details.php` : Page pour gérer le détail d'un produit.

## Améliorations Futures

- Développement d'une page d'accueil permettant aux utilisateurs de voir les produits disponibles.
- Ajout de fonctionnalités de profil pour permettre aux utilisateurs de modifier leurs informations personnelles.
- Mise en place d'un onglet "Paramètres" pour gérer les configurations du site.
- Ajout des photos des produits.

### Product_details

La page `product_details` permet de voir le détail du produit et de modifier les paramètres de ce produit.

### La Base de données

Pour ce projet, nous avons une base de données qui gère les produits et qui peut être modifiée directement par la page `gestion.php`. Cette base de données possède une clé primaire qui est l'ID, puis qui prend en paramètre plusieurs valeurs comme le nom, le prix, la date de modification et la photo si demandée.
La base de données s'appelle `pharmacie`, qui comporte la table `produits`.
La table `user` dans la base de données `pharmacie` permet de stocker les utilisateurs créés par les utilisateurs dans la base de données.
