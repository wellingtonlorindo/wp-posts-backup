# Castos code test: Laravel app

## Requirements

Some time ago, we decided to try our hand at building a WordPress Posts backup service. The idea was that we would use our experience storing Podcast episodes and allow a user to back up their entire library of Post content from WordPress.

This Laravel application code was the prototype start that project, in that is has a very limited set of functionality.

1. It has a home page
2. You can register as a user
3. There is an HTTP API to which you can send a POST request from an external source (like WordPress) to an API endpoint to store the Post data
4. You can view a list of all saved Posts

We would like to you expand on this code, and allow the functionality to become more fully formed.

1. We don't know if this code actually works.
2. There are currently no automated tests in place, to verify this
3. You should be able to log in to your account, and see only the Posts you have saved to your account
4. We would like to expand the user account capabilities to allow for adding/updating and deleting Posts from the database
5. We would like to expand the API capabilities to allow for viewing a list of posts,updating, and deleting posts from the database, via the HTTP API
6. When adding or updating a Post, these two fields should always be required, post_id and post_title

You may choose to implement these requirements in any way you prefer, as long as your work follows good Laravel development practices.

### CodeSubmit

Please organize, design, test and document your code as if it were going into production - then push your changes to the master branch. After you have pushed your code, you may submit the assignment on the assignment page.

All the best and happy coding,

The Castos Team


# TODO

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

5) Finally, run on your terminal:

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