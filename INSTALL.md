## Restart

```
php artisan migrate:reset

```

## Migrate

```
php artisan migrate

```

## Install Passport

```
php artisan passport:install

```

## Save the Keys

In your `.env` file put

```
PERSONAL_CLIENT_ID=1
PERSONAL_CLIENT_SECRET=mR7k7ITv4f...
PASSWORD_CLIENT_ID=2
PASSWORD_CLIENT_SECRET=FJWQRS3PQj...

```

The `PASSWORD_CLIENT_ID`, andd `PASSWORD_CLIENT_SECRET` will be used by the client or its proxy 
to authenticate
