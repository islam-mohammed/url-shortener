# Welcome to the URL Shortner!

## Feature Description

> This web application is a basic URL-shortening service. It has a basic form that consists of 1 text input field and 1 submit button. The text input field is used for “destination URL” which is basically the long URL that will be shortened. Below the input field, there is a table showing the latest created URLs on the system for each user with a paginator.

> The form is only accessible for logged-in users, meaning the user should create a new account and log in to the application to be able to generate his own short links.

> The application has an authentication system, which means that the user can register a new account, log in, log out, and edit his profile.

> The application exposes a POST REST API endpoint that takes “destination” as a required property of the request body. If no “destination” is provided then a non-valid URL is provided it returns a validation error.

## Tech Stack

-   Laravel
-   React.js
-   MySQL
-   Inertiajs

## How to setup a working environment

This project is a simple Laravel 9 application. Laravel 9.x requires a minimum PHP version of 8.0. make sure this version is installed.

```sh
# Copy the example .env file
cp .env.example .env

# Copy the example .env.test file
cp .env.example .env.test

# Install composer dependencies
composer install

# Install npm dependencies
npm install

# Run all migrations and seed the DB for local environment
php artisan migrate:fresh --seed

# Run all migrations for test environment
php artisan migrate:fresh --env=testing

# Generate application key
php artisan key:generate

# Build front end assets (CSS, JS)
npm run dev

# Build the backend and run it
php artisan serve

```

If everything worked well, a project should be accessible by [http://localhost:8000](http://localhost:8000).
