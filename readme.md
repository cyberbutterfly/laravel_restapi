## Example Laravel REST-API

 This is a sample project to show how you could write an API using Laravel 5.

## Running the API

It's very simple to get the API up and running. First, create the database (and database
user if necessary) and add them to the `.env` file.

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_password
```

Then install, migrate, seed:

1. `composer install`
2. `php artisan migrate`
3. `php artisan db:seed`
4. `php artisan serve`

The API will be running on `localhost:8000`.
You can use CURL or Postman to test API.

After db seed, 5 users will be added automatically and their password is '123'.

## Authentication:

This is sample CURL for login.

```
$ curl -X POST localhost:8000/api/login \
  -H "Accept: application/json" \
  -H "Content-type: application/json" \
  -d "{\"email\": \"admin@test.com\", \"password\": \"123\" }"
```

After login, the api_token will be returned. You should use this token whenever call APIs.

```
Authorization: Bearer Jll7q0BSijLOrzaOSm5Dr5hW9cJRZAJKOzvDlxjKCXepwAeZ7JR6YP5zQqnw something like this.
```

## Test:

You can test using command below

```
$ composer test
```
