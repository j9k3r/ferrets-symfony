

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

#### Unit
* [phpunit/phpunit](https://phpunit-documentation-russian.readthedocs.io/ru/latest/installation.html) [symfony/test-pack](https://packagist.org/packages/symfony/test-pack)
* [dama/doctrine-test-bundle](https://packagist.org/packages/dama/doctrine-test-bundle) // плагин работы с доктриной
* [webmozart/assert](https://github.com/webmozarts/assert) // продвинутые асерты
* [liip/test-fixtures-bundle](https://github.com/liip/LiipTestFixturesBundle) // фикстуры
* [fakerphp/faker](https://packagist.org/packages/fakerphp/faker)

#### Doctrine
* [symfony/orm-pack](https://packagist.org/packages/symfony/orm-pack)
* [symfony/uid](https://github.com/symfony/uid)

### Консольные команды
* php bin/console app:users:create-user // создание пользователя


#### Остальное
[mapping user orm xml](https://www.doctrine-project.org/projects/doctrine-orm/en/3.1/reference/basic-mapping.html)
