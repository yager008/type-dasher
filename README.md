SETUP:
1. docker compose build
2. docker compose up
3. create env file <br>
DP_CONNECTION = mysql <br>
DP_PORT = 3306 <br>
DP_HOST = db <br>
DB_PASSWORD <br>

4. app/composer install
5. app/php artisan key:generate
6. app/sudo chmod 777 -R ./
7. php artisan migrate
