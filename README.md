## Preview

Willkommen be <em>LOAN, dem System zur Geräteausleihe für wissenschaftliche und medienpädagogische Einrichtungen</em>. Das System läuft auf einer LNPP-Struktur: 
<ul>
    <li>Ubuntu 24.04</li>
    <li>Nginx</li>
    <li>Postgres</li>
    <li>PHP 8.3</li>
</ul>
und wurde mit <a href="https://laravel.com" target="_blank">Laravel</a> sowie <a href="https://github.com/tailwindlabs/tailwindcss" target="_blank">TailwindCSS</a> programmiert und ist unter einer MIT Lizenz (https://opensource.org/licenses/MIT) verfügbar. Um Zugang zu einem Testaccount unter <a href="http://loan.vdus.de" target="_blank">http://loan.vdus.de</a> zu erhalten, kontaktieren Sie mich bitte unter vincent.dusanek[at]gmail.com.
<br><br>
<em>LOAN | A free loan management system</em> is made with <a href="https://laravel.com" target="_blank">Laravel</a> and <a href="https://github.com/tailwindlabs/tailwindcss" target="_blank">TailwindCSS</a>. Content Language: lang="de". Similar to the Laravel framework, LOAN is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Verleihprozess

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-2.gif)

### Anmeldung

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-1-login.png)

### Geräte

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-2-devices.png)

### Detailansicht: Gerät

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-3-device.png)


## Run locally without Docker

```
# Installation of dependencies
composer install
# Creation of .env
copy .env.example .env
# Set the app key
php artisan key:generate
# Create the database
New-Item -ItemType File .\database\database.sqlite -Force | Out-Null
# (Aus-)kommentieren der (ir-)relevanten DB-Parameter in der .env
DB_CONNECTION=sqlite
DB_DATABASE="ABSOLUTE_DATABASE_PATH"
# Execute the database migrations
php artisan migrate
# Execute seeding of the databae for the first admin acocunt
# admin@test.example with geheimespasswort
php artisan db:seed
# start the web server at http://127.0.0.1:8000
php artisan serve
# set the storage link
php artisan storage:link
```

## Run locally with Docker

Using docker, one can run this app locally using php-fpm, redis and mariadb.

### APP_KEY creation

The laravel app needs an `APP_KEY` which can be created like that:

`echo "APP_KEY=base64:$(openssl rand -base64 32)" >> .env`
and should be added to the compose.yml

### Setup service

The service can be set up using

`docker compose up -d`

Run the migrations and seed the database (to create the first admin user):

`docker compose run loan php artisan migrate --seed`

### Login

Go to http://localhost:8080/ and login with the seeded user.
This is `admin@test.example` with `geheimespasswort` as password by default

You can then start using the app.
