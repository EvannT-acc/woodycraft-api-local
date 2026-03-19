# WoodyCraftWeb

## Description

WoodyCraftWeb est un projet Laravel 10 avec Vite pour le front-end.  
Ce projet est configuré pour PHP >= 8.2 et nécessite Composer et Node.js pour fonctionner correctement.

---

## Prérequis

- PHP >= 8.2
- Composer
- Node.js et npm
- MySQL ou un autre serveur de base de données

---

## Installation

1. Cloner le projet :

```bash
git clone <URL_DU_REPO>
cd WoodyCraftWeb
```

2. installer les depandances PHP
```bash
composer install

npm install

cp .env.example .env
php artisan key:generate
```
3. dans le .env
```SQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_la_base
DB_USERNAME=root
DB_PASSWORD=
```
4. Executer les migrations
```bash
php artisan migrate
```

## lancement 
```bash
php artisan serve

npm run dev
```

