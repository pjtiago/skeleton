#!/bin/bash

# DOCKER COMPOSE
setup() {
    docker-compose build --no-cache
    docker-compose up $1
}

stop() {
    docker-compose down
}

reload() {
    docker-compose stop
    docker-compose up $1
}

# SYMFONY COMMANDS
php() {
  docker exec -it php php bin/console $1
}

make_entity() {
  docker exec -it php php bin/console make:entity
}

# MIGRATIONS
run_migrations() {
  docker exec -it php php bin/console doctrine:migrations:migrate
}

create_migration() {
  docker exec -it php php bin/console make:migration
}

cache_clear() {
  docker exec -it php php bin/console cache:pool:clear --all
}

$1 $2