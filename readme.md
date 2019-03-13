

# Setup

## Install Laravel

Using composer and pushing up to an existing database

````
composer create-project --prefer-dist laravel/laravel pdb-cmr-backend
cd pdb-cmr-backend/
git remote add origin git@github.com:zmon/pdb-cmr-backend.git
git init .
git add .
git commit -m 'Initial commint - installed laravel via composer'

````

# Setup local server iwth Valet
````
cd public
valet park
valet open
````

# Setup database
````
CREATE USER 'cmr'@'localhost' IDENTIFIED WITH MYSQL_NATIVE_PASSWORD BY 'cmr';
CREATE DATABASE cmr;
GRANT ALL PRIVILEGES ON cmr.* to 'cmr'@'localhost' WITH GRANT OPTION;
````

Update .env

````
DB_DATABASE=cmr
DB_USERNAME=cmr
DB_PASSWORD=cmr
````

## Install Auth

````
php artisan make:auth
php artisan migrate
````

## Setup Vue and other npm dependencies 

````
npm install
npm run dev
````



