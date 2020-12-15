# TP1-project [![Build status](https://dev.azure.com/adamzv/TP1-project/_apis/build/status/TP1-project-CI)](https://dev.azure.com/adamzv/TP1-project/_build/latest?definitionId=3)

Team project focused on developing event based calendar for university using Vue.js, Laravel and Docker for deployment.

## Deployment

We are using Azure DevOps for CI/CD and after successful build, services are automatically deployed to our Azure VM running Ubuntu 18.04 (Standard B1ms (1 vcpus, 2 GiB memory)).

## IP addresses

- frontend - http://40.127.143.10:80
- backend - http://40.127.143.10:8000
- http://tp1project.northeurope.cloudapp.azure.com

## Authors

- [Adam Zverka](https://github.com/adamzv) - team leader, continuous integration and deployment, frontend
- ~~[Dušan Angelovič](https://github.com/AngelovicD) - backend, testing~~
- [Kristián Kluka](https://github.com/kristiankluka) - backend, SW architect related tasks
- [Ľudovít Laca](https://github.com/Ludovit-Laca) - backend, DB design
- [Martin Gajdoš](https://github.com/martingajdos) - design, frontend

## Development setup

### Backend

1) Install Composer and XAMPP (php version 7.2)
2) Install required packages using Composer
```bash
composer install
```
3) Create .env file in /backend from .env.example and generate `APP_KEY` using
```bash
php artisan key:generate
``` 
4) Change `DB_HOST=mysql` in .env to your MySQL server IP

    Optional: change DB name or username/password to your preferred values

5) Run `php artisan migrate:fresh --seed` to generate DB tables with data or `php artisan migrate` or `php artisan migrate --seed` to migrate tables and again run seeders

6) Run `php artisan passport:keys` (or `php artisan passport:install`) to generate files and keys required for Laravel Passport

**Attention!** Azure Storage and Mailtrap access keys are required for backend to work

Notes:

`php artisan route:list` to show every route 

### Frontend

1) Install Node.js and npm
2) Run `npm install` in project folder to install required dependencies
3) In frontend .env configuration change API endpoint `VUE_APP_BACKEND_URL=` to your local address (probably `http://localhost/TP1-project/backend/public/api`), also do not commit your changes in this file 
4) Run `npm run serve` to start frontend in development mode on `localhost:8080`

### Docker

Our Docker setup is primarily used for deployment server and some extra setup may be required for proper functioning on your local setup. Our deployment is automated by using Azure DevOps release pipeline.

1) Create your backend `.env` file and change variables for DB, Azure Storage and mail provider
2) Change backend url in frontend `.env` file
3) Build new Docker containers using `docker-compose up --build --force-recreate -d`
4) After MySQL is running you can exec extra php artisan commands for DB migration and passport
```
docker-compose exec backend php artisan migrate:fresh --seed
docker-compose exec backend php artisan passport:install --force
```
These steps are automated in our release pipeline and because of time constraints and Docker setup not being required, we did not move some of these commands to Dockerfiles.