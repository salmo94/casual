  if ! (docker info); then
    echo "docker не запущен. Продолжить невозможно." error
  fi
  if ! (hash docker-compose 2>/dev/null); then
    echo "docker-compose не запущен. Продолжить настройку невозможно." error
  fi
  if ! [[ -f 'docker-compose.yml' ]]; then
    echo "Не найден файл docker-compose.yml. Продолжить настройку невозможно." error
  fi
  if ! (docker volume inspect casual-pg-data >/dev/null); then
    docker volume create --name=casual-pg-data
  fi
  if ! docker-compose up -d; then
      echo "docker-compose не смог" error

  fi
  echo "Сборка и запуск докер контейнеров прошли успешно." success

docker exec c_php /bin/bash -c "php init --env=Development &&
composer install --ignore-platform-reqs &&
cp example.env .env &&
php yii migrate --interactive=0 &&
php yii command/add"



