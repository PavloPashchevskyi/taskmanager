## Example Laravel API

 This is a test project project for Itransition company, which is an API using Laravel 5.

## Running the API

It's very simple to get the API up and running. First, create the database (and database
user if necessary) and add them to the `.env` file.

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_password
```

Then install, migrate, seed, all that jazz:

1. `composer install`
2. `php artisan migrate`
3. `php artisan db:seed`
4. `php artisan serve`

The API will be running on `localhost:8000`.

To send a test email to remind about task (configure your mail server in `.env` file before this) use

 `php artisan reminder:email`