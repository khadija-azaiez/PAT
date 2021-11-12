## Installation

```git clone```

```composer install```

## Create the docker images for the DB & phpmyadmin

```docker-compose up -d```

## Start the project

```php -S 127.0.0.1:8009 -t public```

## Install the assets

```php bin/console assets:install```

## Create the database

```php bin/console doctrine:migration:migrate```

## Create a user with ADMIN ROLE

```php bin/console app:create-user your@email.adress yourpassword```


visit ```127.0.0.1:8009``` and try to connect

visit the admin side to add some products ```127.0.0.1:8009/admin```

return to ```127.0.0.1:8009``` and try to add some products to the basket

finally pass your order

enjoy !