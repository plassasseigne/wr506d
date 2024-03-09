# wr506d

Ce projet a été développé avec Symfony et API Platform dans l'objectif de créer une API basique pour un site de streaming. Vous pouvez récupérer la partie front [juste ici](https://github.com/plassasseigne/wr505d).

## Configuration requise

- PHP 8.1
- Composer
- Symfony CLI

## Installation du projet

- Récupérer le projet
- Installer les dépendances
```sh
composer install
```
- Dupliquer le fichier .env et le nommer .env.local
```sh
cp .env .env.local
```
- Insérer vos informations pour votre base de données
```sh
DATABASE_URL=""
```
- Créer la base de données et la générer avec les entités
```sh
php bin/console doctrine:database:create   # On crée la base de données
php bin/console doctrine:schema:update -f  # On crée les tables
```
- Générer les fixtures
```sh
php bin/console doctrine:fixtures:load
```
- Générer les clés JWT
```sh
php bin/console lexik:jwt:generate-keypair
```
- Initialiser le serveur
```sh
symfony server start
```

## Postman

Vous pouvez tester l'API grâce à la collection Postman "API - WR506D.postman_collection.json". Il vous suffit de l'importer dans le logiciel et de remplacer la variable de collection "API_URL".

## Identifiants

Admin :
```sh
email: user1@mail.com
password: test123
```

Utilisateur :
```sh
email: user2@mail.com
password: test123
```