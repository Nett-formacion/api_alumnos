docker stop $(docker ps -aq)
docker rm $(docker ps -aq)

cd /home/oem/
docker compose up -d
sleep 15
cd laravel/api_alumnos

php artisan serve &

php artisan migrate:fresh --seed

