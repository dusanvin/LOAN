# LOAN

## Allgemeines/ General

### Über

<p>Willkommen be <em>LOAN, dem System zur Geräteausleihe für wissenschaftliche und medienpädagogische Einrichtungen</em>. Das System läuft auf einer LNPP-Struktur: 
<ul>
    <li>Ubuntu 24.04</li>
    <li>Nginx</li>
    <li>Postgres</li>
    <li>PHP 8.3</li>
</ul>
und wurde mit <a href="https://laravel.com" target="_blank">Laravel</a> sowie <a href="https://github.com/tailwindlabs/tailwindcss" target="_blank">TailwindCSS</a> programmiert. Es ist unter einer <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/"target=“_blank”>CC BY-NC-SA 4.0</a> verfügbar. Um Zugang zu einem Testaccount unter <a href="http://loan.vdus.de" target="_blank">http://loan.vdus.de</a> zu erhalten, kontaktieren Sie mich bitte unter vincent.dusanek[at]gmail.com.
<br></p>

<details>
    <summary>About</summary>
    <p><br>Welcome to LOAN, a loan management system for scientific and media education institutions. The system runs on an LNPP structure:
<ul>
    <li>Ubuntu 24.04</li>
    <li>Nginx</li>
    <li>Postgres</li>
    <li>PHP 8.3</li>
</ul>

and was programmed using <a href="https://laravel.com" target="_blank">Laravel</a> and <a href="https://github.com/tailwindlabs/tailwindcss" target="_blank">TailwindCSS</a>. It is available under a <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/"target=“_blank”>CC BY-NC-SA 4.0</a>. To get access to a test account at <a href="http://loan.vdus.de" target="_blank">http://loan.vdus.de</a>, please contact me at vincent.dusanek[at]gmail.com.

<em>LOAN | A free loan management system</em> is made with <a href="https://laravel.com" target="_blank">Laravel</a> and <a href="https://github.com/tailwindlabs/tailwindcss" target="_blank">TailwindCSS</a>. Content Language: lang="de".</p>
    </details>

## Lizenz/ License

### CC-BY-NC-SA-4.0 Lizenz

<p>Dieses Projekt unterliegt der Creative Commons Attribution–NonCommercial–ShareAlike 4.0 International (CC BY-NC-SA 4.0) Lizenz.

- **Erlaubt:** Nutzung, Vervielfältigung, Änderung und Weitergabe für nichtkommerzielle Zwecke, sofern Sie die Quelle angemessen angeben und abgeleitete Werke unter derselben Lizenz verbreiten.
- **Nicht erlaubt:** kommerzielle Nutzung dieses Projekts oder abgeleiteter Werke ohne vorherige Genehmigung.
SPDX-License-Identifier: **CC-BY-NC-SA-4.0**

Für Anfragen zu kommerziellen Lizenzen eröffnen Sie bitte ein Ticket auf GitHub.
<br></p>

<details>
    <summary>CC-BY-NC-SA-4.0 License</summary>
    <p><br>This project is licensed under the **Creative Commons Attribution–NonCommercial–ShareAlike 4.0 International** (CC BY-NC-SA 4.0) license.

- **Allowed:** use, copy, modify, and share **for non-commercial purposes**, provided you give appropriate credit and distribute derivative works under the **same license**.
- **Not allowed:** **commercial use** of this project or any derivative works without prior permission.

SPDX-License-Identifier: **CC-BY-NC-SA-4.0**

For commercial licensing inquiries, please open an issue on GitHub.
</p>
    </details>


## Preview

### Verleihprozess/ Loan process

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-2.gif)

### Anmeldung/ Login

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-1-login.png)

### Geräte/ Devices

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-2-devices.png)

### Detailansicht: Gerät/ Details: Device

![](https://digillab.uni-augsburg.de/wp-content/uploads/2025/08/loan-3-device.png)


## Lokale Installation ohne Docker/ Run locally without Docker

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

## Lokale Installation mit Docker/ Run locally with Docker

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
