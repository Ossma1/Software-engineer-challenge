# Software-engineer-challenge

**Description:**  
This is a challenge from COD NETWORK team, aimed at testing the ability to focus on code quality, software engineering principles, and best practices.

**Technology stack:**  
This project uses **ReactJS** for the frontend and **Laravel** for the backend. The database is configured to use **MySQL**.

## Dependencies  
This project requires **Node**, **npm**, **PHP**, **MySQL**, and **Composer** installed.

## Installation  

1. First, create a `.env` file and paste the content from `.env.example` into it, or simply rename `.env.example` to `.env`. Do the same in the frontend directory. Ensure the URLs in the `.env` (frontend) have the same port as the one Laravel uses.

2. Generate the key for the Laravel project by running the following command in the root directory of the Laravel project:

   ```bash
   npm run generate:key
3. Pour installer le projet, navigue vers son répertoire racine et exécute la commande suivante :

   ```bash
   npm run install:all

4. Pour exécuter les migrations Laravel et remplir la base de données MySQL, exécute la commande suivante :

   ```bash
   npm run migrate:seed
   
5. Pour démarrer les serveurs de développement, utilise la commande suivante :

   ```bash
   npm run start:all

## Configuration  
Si tu préfères utiliser **MySQL** (recommandé), configure le fichier `.env` de Laravel pour te connecter à ta base de données MySQL. Tu peux ignorer les configurations pour SQLite.

## Usage  
Il existe deux façons d'interagir avec l'application :

### CLI  
Tu peux manipuler directement les enregistrements de la base de données via des commandes Artisan.

- Pour créer un produit , navigue dans le répertoire du backend :

   ```bash
   cd backend

- Puis utilise cette commande Artisan :

   ```bash
   php artisan product:create {name} {description} {price} --image_url={image_url} --category_ids={category_ids}

- Pour supprimer un produit :

   ```bash
   php artisan product:delete {product_id}

- Pour créer une catégorie :

   ```bash
   php artisan category:create {name} {parent_id?}

- Pour supprimer une catégorie :

   ```bash
   php artisan category:delete {product_id}

## Interface Web  
Tu peux aussi visualiser, filtrer, trier et créer des produits via l'interface web.

## Tests
Des tests ont été créés pour la création de produits. Pour les exécuter, utilise :

   ```bash
   npm run test:createProduct



