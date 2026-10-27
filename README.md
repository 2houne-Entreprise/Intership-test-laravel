# Internship Test

Toutes les instructions et consignes relatives à ce projet sont décrites et spécifiées dans un [issue GitHub](../../issues) de ce dépôt.

Veuillez consulter l'issue épinglée ou la plus récente pour obtenir les détails complets.

## Workflow

Pour contribuer à la résolution de l'issue, créez une nouvelle branche nommée `feature/<nom-stagiaire>` à partir de `develop`, résolvez l'issue, puis ouvrez une pull request vers `develop`.

---

# TaskFlow – Gestionnaire de tâches collaboratif

Application Laravel 13 (Blade + Breeze, SQLite) : chaque utilisateur gère ses projets et les tâches associées (statut, échéance, pièce jointe).

## Installation

Prérequis : PHP 8.4+, Composer, Node.js / npm, extension `pdo_sqlite`.

```sh
composer install
cp .env.example .env            # DB_CONNECTION=sqlite est déjà configuré
php artisan key:generate
php artisan migrate             # répondre "yes" pour créer database/database.sqlite
php artisan storage:link        # nécessaire pour les liens de téléchargement des pièces jointes
npm install
npm run build
php artisan serve
```

Ouvrir http://localhost:8000, créer un compte via **Register**, puis aller dans **Projets**.

### Tests

```sh
php artisan test
```

Les tests utilisent une base SQLite en mémoire (`phpunit.xml`) : la base locale n'est jamais modifiée.

## Correspondance avec les User Stories

| US | Où regarder |
|---|---|
| US1 Auth | Breeze (stack Blade) : `routes/auth.php`, `app/Http/Controllers/Auth/` |
| US2 Projets | `routes/projects.php` (chargé dans `bootstrap/app.php` avec `web` + `auth`), `ProjectController`, `ProjectRequest` |
| US3 Tâches | `TaskStatus` (enum), `Task`, `StoreTaskRequest` / `UpdateTaskRequest`, `TaskController` |
| US4 Vues | `layouts/main.blade.php` (`@yield('content')`), `components/alert.blade.php`, tableau des tâches dans `projects/show.blade.php` |
| US5 Sécurité | `app/Http/Middleware/EnsureUserOwnsProject.php`, alias `project.owner` |
| US6 Eloquent | `Task::scopeOverdue()`, `Task::getStatusLabelAttribute()`, `with('tasks')` dans `ProjectController@index` |
| US7 Fichiers | migration `add_attachment_path_to_tasks_table`, `Storage::disk('public')` dans `TaskController` |
| US8 Tests | `tests/Feature/ProjectTaskTest.php` |

## Choix techniques

- **Propriété des données à deux niveaux.** Les listes et créations passent toujours par la relation de l'utilisateur connecté (`$request->user()->projects()`), donc `user_id` et `project_id` ne sont jamais remplis depuis le formulaire (ils ne sont pas dans `#[Fillable]`). Pour les routes qui ciblent un projet, le middleware `EnsureUserOwnsProject` renvoie un 403. Il gère le cas où le paramètre est déjà un modèle (route model binding) ou un simple id. Les vérifications d'abord écrites dans les contrôleurs ont été supprimées une fois le middleware en place (voir l'historique Git).
- **Routes imbriquées avec `scopeBindings()`.** `/projects/{project}/tasks/{task}` renvoie un 404 si la tâche n'appartient pas au projet de l'URL. Sans cela, on pourrait modifier la tâche d'un autre utilisateur en passant par son propre projet.
- **Enum PHP `TaskStatus` + enum SQL.** La colonne `status` est un `enum` en base, et le modèle la caste vers `TaskStatus` : une valeur invalide est refusée à la fois par la base, par la validation (`Rule::enum`) et par le typage. Les libellés français sont centralisés dans `TaskStatus::label()` et réutilisés par l'accesseur, les listes déroulantes et le tableau.
- **Form Requests sans duplication.** `UpdateTaskRequest` hérite de `StoreTaskRequest` et préfixe chaque règle par `sometimes` : le formulaire complet et le formulaire rapide de changement de statut (qui n'envoie que `status`) utilisent les mêmes règles.
- **Layout `@extends` au-dessus de Breeze.** Breeze fournit un layout *composant* (`<x-app-layout>` avec `{{ $slot }}`), incompatible avec `@yield`. `layouts/main.blade.php` enveloppe ce composant et expose `@yield('header')` et `@yield('content')`. Les pages de Breeze (dashboard, profil) restent inchangées. Les messages flash sont affichés une seule fois dans ce layout via le composant `<x-alert>`.
- **Scope et accesseur au format classique.** Laravel 13 propose aussi l'attribut `#[Scope]` et les accesseurs `Attribute::make()`. J'ai gardé `scopeOverdue()` et `getStatusLabelAttribute()` car l'énoncé les nomme explicitement.
- **Pièces jointes.** Stockées avec `Storage::disk('public')->putFile('attachments', ...)` (nom aléatoire, donc pas de collision ni de nom de fichier malveillant). Elles sont supprimées du disque quand on les remplace ou qu'on supprime la tâche ou le projet, car le `cascadeOnDelete` SQL ne supprime pas les fichiers. Le lien est construit avec `asset('storage/...')` plutôt que `Storage::url()`, car ce dernier dépend de `APP_URL` (`http://localhost` dans `.env.example`) et donnait un lien cassé avec `php artisan serve` sur le port 8000.

## Plus grande difficulté

L'installation de Breeze sur le squelette fourni. Breeze 2 a détecté Pest (déjà présent dans `composer.json`) et a généré ses tests en Pest au lieu de PHPUnit. Il a aussi remplacé la configuration Tailwind 4 du squelette par Tailwind 3 (`tailwind.config.js`, `postcss.config.js`). J'ai gardé ces choix, qui correspondent au « Tailwind fourni par défaut par Breeze » autorisé par l'énoncé. Mes tests (US8) sont des classes PHPUnit ; `php artisan test` exécute les deux styles. La seconde difficulté a été de concilier le layout composant de Breeze avec l'héritage `@extends` / `@yield` demandé (voir ci-dessus).

## PHP 8.4 dans ce projet

Laravel 13 exige PHP 8.3 minimum. Le code s'appuie surtout sur des fonctionnalités modernes de PHP 8.x : enums « backed » (`TaskStatus`), `match`, opérateur nullsafe (`$task->deadline?->format(...)`), attributs (`#[Fillable]`) et types de retour stricts partout.

Les nouveautés propres à PHP 8.4 (property hooks, visibilité asymétrique, `new` sans parenthèses, `array_find()`) apportent surtout de l'intérêt pour des objets métier ou des DTO. Je ne les ai pas utilisées dans les modèles Eloquent, dont les attributs sont gérés par des méthodes magiques. Le projet a été développé localement avec PHP 8.5, sans utiliser de syntaxe propre à la 8.5 (par exemple l'opérateur pipe `|>`), pour rester compatible avec PHP 8.4.

## Remarques

- `.env` n'est pas versionné. `.env.example` contient déjà `DB_CONNECTION=sqlite`, et `database/database.sqlite` est créé par `php artisan migrate`.
- Laravel Boost, `.junie/` et `AGENTS.md` proviennent du squelette fourni par l'entreprise et n'ont pas été modifiés.
- `npm audit` signale des vulnérabilités dans des dépendances de **développement** (outils de build : vite, postcss, concurrently, axios épinglé par le squelette). Je ne les ai pas mises à jour pour ne pas modifier les dépendances fournies.
- Les fichiers du disque `public` sont accessibles à toute personne qui connaît leur URL (noms aléatoires, donc non devinables). Pour des documents confidentiels, il faudrait utiliser le disque `local` et une route de téléchargement protégée par le middleware `project.owner`.

## Méthode de travail

J'ai travaillé avec un assistant IA (Claude) en binôme : je pilotais le projet, il m'expliquait les concepts et rédigeait du code.

- **Organisation et décisions :** j'ai découpé le travail par User Story et choisi l'ordre des étapes. J'ai aussi organisé l'historique Git (un ou deux commits par US, référencés à l'issue) et vérifié la branche et le contenu de chaque commit avant de pousser. Enfin, j'ai fait les choix de cadrage : PHPUnit pour mes tests, ne pas modifier l'outillage fourni (Boost, `AGENTS.md`), ne pas forcer la mise à jour des dépendances npm.
- **Mise en place :** j'ai installé et configuré le projet (Composer, `.env`, SQLite, npm) et installé Breeze. J'ai écrit moi-même la migration `projects`, les modèles `Project` / `User` et la `ProjectFactory`.
- **Code rédigé par l'assistant :** à partir des routes et du contrôleur des projets (US2), l'assistant a écrit la majorité du code (contrôleurs, Form Requests, middleware, vues, scope, accesseur, upload, tests). Il l'a vérifié par des tests automatisés, et j'ai validé chaque étape avant de la committer.

L'énoncé demandait de travailler sans aide extérieure : je préfère être transparent sur ce point. Je peux expliquer les choix techniques décrits ci-dessus, et je suis prêt à refaire seul une partie de l'application si vous le souhaitez.
