<<<<<<< HEAD
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

=======
<p align="center">
  <a href="https://github.com/ludo-mastant/WoodyCraftWeb" target="_blank">
    <img src="IMG/Logo_Woody_Bleu.png" width="400" alt="WoodyCraftWeb Logo">
  </a>
</p>


## À propos de WoodyCraftWeb

**WoodyCraftWeb** est une boutique en ligne spécialisée dans les **puzzles 3D en bois**. Nos produits sont conçus pour offrir un **moment créatif, amusant et relaxant** pour tous les âges.  

### Caractéristiques principales

- Puzzles 3D de haute qualité et faciles à assembler.  
- Designs uniques inspirés de la nature, des animaux et des monuments célèbres.  
- Instructions détaillées et illustrations incluses.  
- Livraison rapide et service client dédié.  
- Options de paiement sécurisées.

## Catalogue

Nous proposons une large gamme de puzzles 3D :  

- Animaux : lions, éléphants, oiseaux…  
- Véhicules : voitures anciennes, avions, bateaux.  
- Monuments : tours célèbres, ponts, châteaux.  
- Personnalisables : certains modèles peuvent être gravés ou peints à votre goût.  

Chaque puzzle est livré avec une image et un guide de montage pour faciliter l’expérience.

## 1 Installation / Lancement du projet

### 1.1 Clonez le projet :  
```bash
git clone https://github.com/ton-username/WoodyCraftWeb.git
```

### 1.2 Installez les dépendances :
```bash
composer install
npm install
npm run dev
```
Configurez votre fichier ***.env*** avec vos informations de ***base de données*** et ***clés API***.

### 1.3 Lancez le serveur :
```bash
php artisan serve
```
Contribuer

Vous souhaitez contribuer au développement de **WoodyCraftWeb** ? Nous acceptons les **suggestions**, les idées de nouveaux puzzles ou les **améliorations** du site. pour plus d’informations venez en privé.
.
## Licence

WoodyCraftWeb est open-source et distribué sous ***licence MIT***.
>>>>>>> bb0ed51342e2d32672e612ab2694876459226cb3
