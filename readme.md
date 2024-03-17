

## Устновка симфони версии * из php-fpm
для установки если она еще не произведена запускаем из контейнера устанавливаем переменную и запускаем скрипт "/app/docker/php/setup.sh"
```
SYMFONY_VERSION=7.0.*
```

[//]: # (далее выполните в /app/)
[//]: # (```)
[//]: # (composer install)
[//]: # (```)

ВНИМАНИЕ в случае если образ уже был установлен, то его необходимо удалить выполнив
```
docker rmi docker_php-fpm
```



## Переменные окружиения
```
Обязательные:
 DB_HOST=
```
* Swagger:  - документация доступна только для  **super_admin**

## После настройки
```
php bin/console lexik:jwt:generate-keypair //генерация ключ пары

```

### Содержит пакеты:
#### JWT
* [lexik/LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle)
* [markitosgv/JWTRefreshTokenBundle](https://github.com/markitosgv/JWTRefreshTokenBundle)

#### Консольные команды
* php bin/console app:users:create-user // создание пользователя 
