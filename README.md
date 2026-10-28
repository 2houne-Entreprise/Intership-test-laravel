
# TaskFlow — Gestion de projets et de tâches

TaskFlow est une application web développée avec Laravel 13 permettant aux utilisateurs de gérer leurs projets et leurs tâches dans un espace personnel sécurisé.

## Technologies utilisées

- PHP 8.4
- Laravel 13
- Laravel Breeze (Blade)
- SQLite
- Eloquent ORM
- Blade et CSS / Tailwind fourni par Breeze
- PHPUnit
- Laravel Pint
- Git

## Fonctionnalités

### Authentification
- Inscription et connexion des utilisateurs
- Déconnexion
- Protection des pages par le middleware `auth`

### Gestion des projets
- Création, consultation, modification et suppression
- Association des projets à leur créateur
- Accès limité aux projets de l'utilisateur connecté

### Gestion des tâches
- Ajout et suppression de tâches
- Modification rapide du statut
- Statuts : En attente, En cours, Terminée
- Date limite facultative
- Validation avec Laravel Form Requests
- Affichage des erreurs de validation

### Sécurité
- Middleware personnalisé `EnsureUserOwnsProject`
- Contrôle de propriété des projets
- Réponse HTTP 403 en cas de modification non autorisée
- Requêtes Eloquent filtrées par utilisateur

### Eloquent avancé
- Relations `hasMany` et `belongsTo`
- Scope `overdue()` pour les tâches en retard
- Accessor `status_label` pour les statuts en français
- Eager Loading avec `with('tasks')`

### Pièces jointes
- Envoi de fichiers associés aux tâches
- Stockage sur le disque public Laravel
- Téléchargement des pièces jointes

## Prérequis

- PHP 8.4
- Composer
- Node.js et npm
- Extensions PHP : mbstring, pdo_sqlite, sqlite3, fileinfo, openssl, curl, zip

## Installation

### 1. Cloner le projet

```bash
git clone URL_DU_DEPOT
cd taskflow
```

Remplacer `URL_DU_DEPOT` par l'adresse réelle du dépôt GitHub.

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer l'environnement

Copier `.env.example` vers `.env`.

Sous Windows PowerShell :

```powershell
Copy-Item .env.example .env
```

Configurer SQLite dans `.env` :

```dotenv
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
```

Créer le fichier `database/database.sqlite` s'il n'existe pas.

Sous Windows PowerShell :

```powershell
New-Item database/database.sqlite -ItemType File
```

### 4. Générer la clé de l'application

```bash
php artisan key:generate
```

### 5. Créer les tables

```bash
php artisan migrate
```

### 6. Configurer le stockage public

```bash
php artisan storage:link
```

### 7. Installer et compiler les ressources frontend

```bash
npm install
npm run build
```

### 8. Démarrer Laravel

```bash
php artisan serve
```

Ouvrir dans le navigateur :

http://127.0.0.1:8000

Créer un compte puis accéder à `/projects`.

## Tests

Exécuter tous les tests :

```bash
php artisan test
```

Tests fonctionnels spécifiques :

```bash
php artisan test --filter=ProjectTest
php artisan test --filter=TaskTest
```

Les tests vérifient notamment :
- La redirection des visiteurs non authentifiés
- La création d'un projet
- Le refus d'une modification non autorisée (HTTP 403)
- Le refus d'une tâche sans titre

Dernière exécution vérifiée :
29 tests réussis, 72 assertions.

## Qualité du code

Le projet utilise Laravel Pint pour le formatage PHP :

```bash
./vendor/bin/pint
```

Sur Windows :

```powershell
.\vendor\bin\pint
```

## Choix techniques

### Laravel et Eloquent
Laravel fournit une architecture MVC facilitant la séparation entre les modèles, les contrôleurs et les vues.

Eloquent permet de gérer les relations entre les utilisateurs, les projets et les tâches.

### SQLite
SQLite a été choisi pour sa simplicité d'installation et sa facilité d'utilisation dans un environnement de développement local.

### Laravel Breeze
Breeze fournit une authentification légère avec Blade, sans avoir besoin d'un framework frontend supplémentaire.

### Form Requests
Les règles de validation des tâches sont séparées des contrôleurs afin de rendre le code plus lisible et réutilisable.

### Middleware
Le middleware `EnsureUserOwnsProject` centralise le contrôle d'accès aux projets et protège les opérations sensibles.

### PHP 8.4
PHP 8.4 permet d'utiliser les fonctionnalités modernes du langage et fournit l'environnement demandé pour Laravel 13.

## Difficultés rencontrées

Le principal défi technique a été la mise en place d'un contrôle d'accès garantissant qu'un utilisateur ne peut pas modifier les projets appartenant à un autre utilisateur.

La configuration de PHP, des extensions nécessaires et de l'environnement SQLite a également nécessité des vérifications.

Ces difficultés ont été traitées par une séparation des responsabilités et des tests fonctionnels.

## État du projet

Les principales fonctionnalités sont implémentées et les tests existants passent.

Des vérifications complémentaires peuvent être ajoutées pour couvrir davantage de cas de sécurité et de validation.

## Auteur

Projet TaskFlow — Challenge de développement Laravel.
