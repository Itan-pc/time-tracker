# Backend

## Project setup
```
composer install
```

## Migrations
```
#configured database connect in .env file
DATABASE_URL="mysql://databaseuser:databasepassword@127.0.0.1:3306/database_name?serverVersion=5.7"

# run a migration
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### Generate jwt keys
```
php bin/console lexik:jwt:generate-keypair 
```