# Install OSX DeskTop

These instructions assume you have git, npm, 
composer, php, mysql installed, 
that you have a running Laravel environment with Valet.


Adjust:

1. `DB_` setting to reflect the database you will use
2. `TEST_USER_PASSWORD` to the test password you want for the inital user. 
    See `database/seeds/UserTableSeeder.php` for user name
3. `MAIL_` should be adjusted if you are goint to test Forgot password or other functions that meil.    
3. If you regenerate Passport Keys you man need to adjust `PASSWORD_CLIENT_ID`

## Install the dependencies

```
composer install
npm install
npm run dev
```

## Crate database tables and seed them

```
php artisan migrate
php artisan db:seed
```

## Setup Passport

You can skip this if you are not going to use the API.

````
php artisan passport:keys --force
````

## Setup hosting

You can setup any `apache` hosting environment you would like.

For OSX with [Valet](https://laravel.com/docs/5.8/valet) installed the following will work from the 
top directory of your project

```
valet link
valet open
```

You should now beable to login as `paulb@savagesoft.com`  Using the password you set in the `.env`



