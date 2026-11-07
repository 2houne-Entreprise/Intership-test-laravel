# TaskFlow

Test technique 2Houne : gestion de projets et de tâches (Laravel 13, PHP 8.4, SQLite, Breeze).

## Lancer le projet

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

Compte de démo : `demo@taskflow.test` / `password`

Tests : `php artisan test`

## Mes choix

J'ai gardé le code simple et facile à relire, avec un commit par étape.
Chaque utilisateur ne voit que ses propres projets : si quelqu'un essaie
d'ouvrir le projet d'un autre, l'accès est refusé.

Ma plus grosse difficulté a été l'installation : PHP n'était pas installé
sur mon PC, et la mise en ligne ne marchait pas au début parce que
Laravel 13 a besoin de PHP 8.4. PHP 8.4 m'a donc été indispensable,
et il rend le code plus clair et plus moderne.
