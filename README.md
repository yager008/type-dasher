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

SEEDER: <br>
php artisan db:seed --class=SavedTextsTableSeeder <br>
php artisan db:seed --class=TypeResultsTableSeeder


   Breeze:
   composer require laravel/breeze --dev
   php artisan breeze:install
   php artisan migrate
   npm install
   npm run dev

  cd /var/www/first_real_laravel_docker_projcet/ git pull origin type-dasher-prod
        cp .env.example .env
        sed -i 's/#\?\s*DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
        sed -i 's/#\?\s*DB_PORT=.*/DB_PORT=3306/' .env
        sed -i 's/#\?\s*DB_HOST=.*/DB_HOST=db/' .env
        sed -i 's/#\?\s*DB_PASSWORD=.*/DB_PASSWORD=/' .env
        sed -i 's/#\?\s*DB_DATABASE=.*/DB_DATABASE=lardocker/' .env
        sed -i 's/#\?\s*DB_USERNAME=.*/DB_USERNAME=root/' .env
        sed -i 's/#\?\s*APP_ENV=.*/APP_ENV=production/' .env
        docker-compose up --build -d
        docker-compose exec app composer install
        docker-compose exec app php artisan key:generate
        docker-compose exec app chmod 777 -R ./
        docker-compose exec app php artisan migrate --force
        docker-compose exec app npm install
        docker-compose exec app npm run build
        docker-compose exec app cp /var/www/public/.vite/manifest.json /var/www/public/manifest.json
