# TD3 - Système de Gestion Académique

Application web de gestion des étudiants, enseignants et cours développée en PHP avec une architecture MVC.

## 📋 Description

TD3 est une application web complète permettant la gestion d'une institution académique. Elle offre les fonctionnalités suivantes :

- **Gestion des étudiants** : Création, modification, suppression et consultation des étudiants
- **Gestion des enseignants** : Création, modification, suppression et consultation des enseignants
- **Gestion des cours** : Création, modification, suppression et consultation des cours
- **Gestion des modules** : Organisation des matières par modules
- **Gestion des matières** : Organisation des cours par matières

## 🚀 Installation

### Prérequis

- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Apache ou Nginx avec mod_rewrite
- Composer (pour les dépendances)

### Étapes d'installation

1. **Cloner ou télécharger le projet**
   ```bash
   cd /srv/http/r301devweb/TD3
   ```

2. **Installer les dépendances**
   
   ⚠️ **Important** : Le dossier `vendor/` n'est pas inclus dans l'archive ZIP.
   Vous devez installer les dépendances avec Composer :
   ```bash
   composer install
   ```
   
   Cette commande installera automatiquement les dépendances listées dans `composer.json`
   (notamment `vlucas/phpdotenv` pour la gestion des variables d'environnement).

3. **Configurer la base de données**
   
   Créer un fichier `.env` à la racine du projet avec les informations suivantes :
   ```env
   DB_HOST=localhost
   DB_NAME=r301project
   DB_PORT=3306
   DB_USER=simpleuser
   DB_PASS=simplepass
   ```

4. **Créer la base de données**
   
   Importer le fichier `sqldumb.sql` dans votre base de données MySQL/MariaDB :
   ```bash
   mysql -u simpleuser -p r301project < sqldumb.sql
   ```
   
   Ou via phpMyAdmin : Sélectionner votre base de données, puis onglet "Importer" et sélectionner le fichier `sqldumb.sql`.
   
   Cette importation créera automatiquement les tables suivantes :
   - `mp_users` : Utilisateurs du système
   - `mp_etudiants` : Étudiants
   - `mp_enseignants` : Enseignants
   - `mp_modules` : Modules
   - `mp_matieres` : Matières
   - `mp_cours` : Cours

5. **Configurer les permissions**
   
   S'assurer que le serveur web a les permissions de lecture sur tous les fichiers :
   ```bash
   sudo chown -R www-data:www-data /srv/http/r301devweb/TD3
   sudo chmod -R 755 /srv/http/r301devweb/TD3
   ```

## 📁 Structure du projet

```
TD3/
├── class/              # Classes métier (Model)
│   ├── cours.class.php
│   ├── enseignant.class.php
│   ├── etudiant.class.php
│   ├── matiere.class.php
│   ├── module.class.php
│   └── myAuthClass.php
├── cours/              # Module Cours
│   ├── controllers/   # Contrôleurs
│   └── views/          # Vues
├── enseignants/        # Module Enseignants
│   ├── controllers/
│   └── views/
├── etudiants/          # Module Étudiants
│   ├── controllers/
│   └── views/
├── modules/             # Module Modules
│   ├── controllers/
│   └── views/
├── matieres/            # Module Matières
│   ├── controllers/
│   └── views/
├── inc/                 # Fichiers inclus
│   ├── head.php        # En-tête HTML
│   ├── footer.php      # Pied de page
│   ├── top.php         # Barre de navigation
│   └── content.php     # Routeur MVC
├── lib/                 # Bibliothèques
│   ├── mypdo.php       # Connexion PDO
│   ├── security.lib.php # Sécurité et authentification
│   └── myproject.lib.php # Fonctions utilitaires
├── css/                 # Feuilles de style
│   └── styles.css
├── js/                  # Scripts JavaScript
│   └── scripts.js
├── docs/                # Documentation générée (PHPDoc)
├── vendor/              # Dépendances Composer
├── index.php            # Point d'entrée principal
├── login.php            # Page de connexion
├── main.inc.php         # Structure MVC principale
├── phpdoc.xml           # Configuration PHPDoc
├── composer.json        # Dépendances PHP
└── README.md            # Ce fichier
```

## 🔐 Authentification

L'application utilise un système d'authentification basé sur les sessions PHP. Les identifiants de connexion sont stockés dans la table `mp_users`.

**Note** : Pour la première utilisation, créer un utilisateur administrateur dans la base de données.

## 🎨 Interface utilisateur

L'application dispose d'une interface moderne et responsive avec :

- **Design interactif** : Animations et transitions fluides
- **Icônes Font Awesome** : Pour une meilleure expérience utilisateur
- **Autocomplétion d'adresses** : Utilisation de l'API Adresse Data Gouv pour faciliter la saisie
- **Tooltips** : Informations contextuelles sur les boutons d'action
- **Modales de confirmation** : Pour les actions critiques (suppression)

## ⚙️ Fonctionnalités principales

### Gestion des étudiants
- Création avec génération automatique d'utilisateur associé
- Capitalisation automatique des noms et prénoms
- Autocomplétion des adresses avec remplissage automatique de la ville et du code postal
- Modification et suppression

### Gestion des enseignants
- Création avec génération automatique d'utilisateur associé
- Capitalisation automatique des noms et prénoms
- Autocomplétion des adresses
- Modification et suppression

### Gestion des cours
- Création de cours avec association à une matière et un enseignant
- Possibilité de créer un module ou une matière lors de la création d'un cours
- Modification et suppression

### Gestion des modules
- CRUD complet (Create, Read, Update, Delete)
- Attribution de coefficients

### Gestion des matières
- CRUD complet
- Association à un module
- Attribution de coefficients

## 📚 Documentation

La documentation PHPDoc est générée automatiquement. Pour la générer :

```bash
cd /srv/http/r301devweb/TD3
php /home/lazou/tools/phpdoc/phpDocumentor.phar run -v -c "./phpdoc.xml"
```

La documentation sera disponible dans le dossier `docs/` et accessible via :
```
http://localhost/r301devweb/TD3/docs/index.html
```

## 🛠️ Technologies utilisées

- **Backend** : PHP 8.4
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS** : Custom CSS (remplacement de W3.CSS)
- **Bibliothèques** :
  - Font Awesome 6.4.0 (icônes)
  - Google Fonts (Quicksand)
  - vlucas/phpdotenv (gestion des variables d'environnement)
- **Documentation** : PHPDoc

## 📝 Configuration

### Variables d'environnement (.env)

Le fichier `.env` doit contenir :

```env
DB_HOST=localhost      # Hôte de la base de données
DB_NAME=r301project    # Nom de la base de données
DB_PORT=3306          # Port MySQL
DB_USER=simpleuser    # Utilisateur MySQL
DB_PASS=simplepass    # Mot de passe MySQL
```

### Configuration Apache

Pour que l'application fonctionne correctement, activer le module `mod_rewrite` :

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Configuration de la base de données

Les tables sont créées avec les préfixes suivants :
- `mp_users` : Utilisateurs
- `mp_etudiants` : Étudiants
- `mp_enseignants` : Enseignants
- `mp_modules` : Modules
- `mp_matieres` : Matières
- `mp_cours` : Cours

## 🐛 Résolution de problèmes

### Erreur de connexion à la base de données

1. Vérifier que MySQL est démarré : `sudo systemctl status mysql`
2. Vérifier les informations dans `.env`
3. Vérifier que l'utilisateur MySQL a les droits nécessaires

### Styles non appliqués

1. Vider le cache du navigateur (Ctrl+F5)
2. Vérifier que le fichier `css/styles.css` est accessible
3. Vérifier les permissions des fichiers CSS

### Erreurs de type (TypeError)

Les erreurs de type sont généralement dues à des valeurs non castées. Tous les champs numériques doivent être explicitement castés en `int` ou `float` lors de leur assignation.

## 👤 Auteur

**Kime Marwa**
- Date : 2 novembre 2025
- Version : 1.0

## 📄 Licence

Ce projet est un travail académique réalisé dans le cadre du TD3.

## 🔄 Changelog

### Version 1.0 (2 novembre 2025)
- Initialisation du projet
- Implémentation de l'architecture MVC
- Gestion complète des étudiants, enseignants et cours
- Interface utilisateur moderne et interactive
- Documentation PHPDoc complète
- Autocomplétion d'adresses avec API Adresse Data Gouv
- Capitalisation automatique des noms et prénoms

