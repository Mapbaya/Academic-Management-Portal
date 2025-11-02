# Instructions pour publier sur GitHub

## 📋 Étapes pour créer le repository sur GitHub

### 1. Créer un nouveau repository sur GitHub

1. Allez sur [GitHub.com](https://github.com) et connectez-vous
2. Cliquez sur le bouton **"+"** en haut à droite → **"New repository"**
3. Remplissez les informations :
   - **Repository name** : `TD3-Gestion-Academique` (ou un nom de votre choix)
   - **Description** : `Application web de gestion académique développée en PHP avec architecture MVC`
   - **Visibilité** : ☑️ **Public** (pour que d'autres puissent l'utiliser)
   - **NE COCHEZ PAS** "Initialize this repository with a README" (on a déjà un README)
   - Cliquez sur **"Create repository"**

### 2. Connecter votre projet local à GitHub

Après avoir créé le repository, GitHub vous donnera des instructions. Voici les commandes à exécuter :

```bash
cd /srv/http/r301devweb/TD3

# Ajouter le remote GitHub (remplacez VOTRE_USERNAME par votre nom d'utilisateur GitHub)
git remote add origin https://github.com/VOTRE_USERNAME/TD3-Gestion-Academique.git

# Renommer la branche en main si ce n'est pas déjà fait
git branch -M main

# Pousser le code vers GitHub
git push -u origin main
```

### 3. Vérifier que tout est bien publié

1. Rafraîchissez la page GitHub de votre repository
2. Vous devriez voir tous vos fichiers (code, README, sqldumb.sql, etc.)
3. Vérifiez que le fichier `.env` n'est **PAS** visible (c'est normal grâce au .gitignore)

## 🔐 Fichiers exclus (sécurité)

Grâce au fichier `.gitignore`, ces fichiers ne seront **PAS** publiés sur GitHub :
- `.env` (identifiants de base de données)
- `vendor/` (dépendances, à installer avec `composer install`)
- `docs/` (documentation générée)
- Fichiers temporaires et caches

## 📝 Notes importantes

- ✅ Le fichier `sqldumb.sql` est inclus (dump de la base de données)
- ✅ Le `README.md` contient toutes les instructions d'installation
- ✅ Tous les fichiers de code source sont inclus
- ✅ Les utilisateurs pourront cloner et installer facilement avec `composer install`

## 🚀 Pour les utilisateurs du projet

Une fois publié, d'autres pourront cloner votre projet avec :

```bash
git clone https://github.com/VOTRE_USERNAME/TD3-Gestion-Academique.git
cd TD3-Gestion-Academique
composer install
# Créer le fichier .env et importer sqldumb.sql
```

## ⚙️ Configuration Git (optionnel)

Si vous n'avez pas encore configuré Git globalement :

```bash
git config --global user.name "Kime Marwa"
git config --global user.email "votre.email@example.com"
```

---

**Bon courage avec la publication ! 🎉**

