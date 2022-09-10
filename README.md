# mini-CRM

## Setup

### To launch the app on your local machine

1. Download the source code
2. Run The following commands while in root directory:
   1. `composer install`
   2. `cp .env.example .env`
   3. `php artisan key:generate`
   4. `php artisan jwt:secret`
   5. `php artisan migrate:refresh --seed`
3. Launch your database server and configure `.env` file to match the database configuration
4. Run `php artisan serve`

### To launch the app in Docker

1. Download the source code
2. Run `docker-compose up` while in root directory
3. Run `docker exec {app container id} php artisan migrate --seed` (use --seed flag if you want to seed your database with fake data)

### How to authenticate

- Use the `POST api/auth/login` route with admin credentials, to get a token.
- Attatch the token to every request you send. (all possible routes can be found in the Postman collection file found in the root directory)
