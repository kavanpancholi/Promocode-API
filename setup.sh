#!/usr/bin/env bash

set -e

if [ ! -f ".env" ]; then
   cp .env.example .env
fi
echo Starting services
docker-compose up -d
echo Host: 127.0.0.1
until docker-compose exec mysql mysql -h 127.0.0.1 -u root -psecret -D kavan --silent -e "show databases;"
do
  echo "Waiting for database connection..."
  sleep 5
done
echo Seeding database
rm -f bootstrap/cache/*.php
docker-compose exec laravel php /var/www/artisan key:generate
docker-compose exec laravel php /var/www/artisan migrate:fresh --seed --force
echo Open http://localhost:8080 in Browser
python -m webbrowser http://localhost:8080
