## Ticket API

This is a backend project that provides a RESTful API for a ticketing system. It is built with Laravel.

### Installation
1 - Clone the repository
```bash
git@github.com:exqlusive/ticketing-app.git
```

2 - Install dependencies
```bash
composer install
```

3 - Create a `.env` file
```bash
cp .env.example .env
```

4 - Generate an application key
```bash
php artisan key:generate
```

5 - Create a database and update the `.env` file with the database credentials

6 - Run the migrations
```bash
php artisan migrate
```

7 - Start the server
```bash
php artisan serve
```
