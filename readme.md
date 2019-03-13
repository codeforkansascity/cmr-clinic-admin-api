

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

## Create First Users

1. Create command
```
php artisan make:command MakeFirstUser
```

2. Add to app/Console/Kernel.php
```
protected $commands = [
    'App\Console\Commands\MakeFirstUser',
];
```

3. Setup the command

```
protected $signature = 'cmr:make-first-user';
  .
  .
  .
  
public function handle()
{
    echo env('APP_NAME');

    $user_name = 'Paul Barham';
    $user_email = 'paulb@savagesoft.com';

    $user  = \App\User::where('email', $user_email)->first();

    if ( $user ) {
        $this->error( "User |$user_name|$user_email| exists, cannot add");
        die();
    }

    $user = \App\User::create([
        'email' => $user_email,
        'name' => $user_name,
        'password' => bcrypt('secret')
    ]);
}
```

# Create first user
````
php artisan cmr:make-first-user
````

# Setup Passport

````
php artisan passport:keys --force
php artisan passport:install --force
````
# Create accessToken for API
  
````
  php artisan tinker
  >>> $user = User::find(1)
  >>> $token = $user->createToken('Hackerpair')->accessToken
  => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIs...Um1Py-KdjXfQ"
````

# Added token to .env for testing

````
TEST_API_TOKEN="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1Ni..."
````

# Test the API
In OSX not your Vagrant box

````
php artisan aps:api-test
````

# Test website
````
https://cms.apskc.ldev/login
````

# Added CrudGenderator
See [https://github.com/zmon/laravel-crud-generator](https://github.com/zmon/laravel-crud-generator)

````
php artisan make:crud student
````

For each of the existing tables you will need to create a migration simular to 2019_01_04_192740_roles_update_time_stamps.php




