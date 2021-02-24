# WP Posts Backup


## TODO

- Add api token management page
- Improve api authentication with Laravel Passport


## Instalação

1) Install composer globally on your system https://getcomposer.org/
2) Meet all Laravel's requirements https://laravel.com/docs/6.x/installation#server-requirements
3) Clone the repository
2) In the *php-developer-laravel-project-qpguqm directory*, run on your terminal
```
    composer install --optimize-autoloader --no-dev
```
3) Make a copy of the .env.example file and then rename it to .env
4) In the .env file, fill your database configuration
```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
```
5) Migrate the database
```
    php artisan migrate
```

6) Finally, run on your terminal:

```
    php artisan config:cache; php artisan view:cache; php artisan serve
```
Then check where the Laravel development server started. (Usually is http://127.0.0.1:8000)

## Running tests
```
    composer run test
```


## API

Check the **docs** directory.