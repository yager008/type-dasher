First time setup:
1. docker compose up --build
2. create env file
   DB_CONNECTION = mysql <br>
   DB_PORT = 3306 <br>
   DB_HOST = db <br>
   DB_PASSWORD <br>
3. app/composer install
4. app/php artisan key:generate
5. app/chmod 777 -R ./
6. app/php artisan migrate
7. app/npm install
8. app/npm run build
9. cp /var/www/public/.vite/manifest.json /var/www/public/manifest.json

if locally:
9. Start vite: npm run dev -- --host 0.0.0.0

Next time setup:
1. docker compose up --build
2. docker exec -it app bash/npm run dev -- --host 0.0.0.0

SEEDER (when user with id 1 already exists): <br>
php artisan db:seed --class=SavedTextsTableSeeder <br>
php artisan db:seed --class=TypeResultsTableSeeder


Breeze:
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
npm install
npm run dev

![Alt text](./readmeimgs/TypeDash.jpg)
![Alt text](./readmeimgs/TypeDash2.jpg)
![Alt text](./readmeimgs/TypeDash3.jpg)
