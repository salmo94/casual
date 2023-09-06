function checkDocker() {
    if ! (docker info); then
      echo "docker не запущений. Неможливо продовжити."
      exit
    fi

}

function checkDockerCompose() {
    if ! (hash docker-compose 2>/dev/null); then
      echo "docker-compose не запущений. Неможливо продовжити налаштування."
      exit
    fi

}

function checkDockerComposeYml() {
    if ! [[ -f 'docker-compose.yml' ]]; then
      echo "Не знайдено файл docker-compose.yml. Неможливо продовжити налаштування."
      exit
    fi

}

function checkPgVolume() {

   if ! (docker volume inspect casual-pg-data >/dev/null); then
       docker volume create --name=casual-pg-data
   fi

}

function upDockerCompose() {
    if ! docker-compose up -d; then
      echo "docker-compose не зміг"
      exit
    fi
}

function installProject() {
    if ! [[ -f '.env' ]]; then
      docker exec c_php /bin/bash -c "php init --env=Development &&
      composer install --ignore-platform-reqs &&
      cp example.env .env &&
      php yii migrate --interactive=0 &&
      php yii create-admin/default &&
      php yii create-admin/role"
    else
      docker exec c_php /bin/bash -c "composer install --ignore-platform-reqs && php yii migrate --interactive=0"
    fi
}

function checkHosts() {
    HOSTS='127.0.0.1 casual-backend.docker'
    if grep "${HOSTS}" /etc/hosts | grep -v '^#'; then
      echo "${HOSTS} вже присутні в /etc/hosts"
    else
      sudo /bin/bash -c "echo -e '\n${HOSTS}' >> /etc/hosts"
      echo "${HOSTS} успішно додані в /etc/hosts."
    fi
}

checkDocker
checkDockerCompose
checkDockerComposeYml
checkPgVolume
upDockerCompose
installProject
checkHosts

echo 'Розгортання проекту пройшоло успішно!'
echo 'URL проекту: http://casual-backend.docker'
echo 'Логін: admin,Пароль: admin777'
