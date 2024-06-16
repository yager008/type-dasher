SETUP:
1. docker compose build
2. docker compose up
3. create env file
   !!! DP_PORT = 3306!!!
4. app/composer install
5. app/php artisan key:generate
6. app/sudo chmod 777 -R ./
7. php artisan migrate
8. congrats

Breeze:
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
npm install
npm run dev

9. Start vite:
npm run dev --host

npm run dev -- --host 0.0.0.0
