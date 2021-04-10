# Бот для VK
![Workflow Status](https://github.com/Arslav/vk-bot/actions/workflows/php.yml/badge.svg)
![Issues](https://img.shields.io/github/issues/Arslav/vk-bot)
![GitHub last commit](https://img.shields.io/github/last-commit/Arslav/vk-bot)

TODO...

## Используемые библиотеки
* [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html)
* [PHP-DI](https://php-di.org/)
* [Simple VK](https://simplevk.scripthub.ru/v2/)
* [Carbon](https://carbon.nesbot.com/docs/)
* [Monolog](https://github.com/Seldaek/monolog)

## Установка
### Подготовка
Создайте сообщество VK, получите ключ API (в разделе настройки->работа с API), выставите права доступа к сообщению сообщетсва. Добавьте ваш сервер во вкладке Callback API, версия API 5.101, в типе событий укажите "Входящие сообщения". Далее, в разделе "Сообщения", включите "сообщения сообщества".
### Установка
Скачайте проект и выполните следующие команды:
```
composer update
php vendor/bin/doctrine orm:schema-tool:update
```
### Настройка
Создайте файл `.env` в корне проекта и впишите в него свои настройки. Пример можете найти в файле `.env.example`

## TODO...
TODO...