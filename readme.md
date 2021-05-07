# Бот для VK
![Workflow Status](https://github.com/Arslav/vk-bot/actions/workflows/php.yml/badge.svg)
![Issues](https://img.shields.io/github/issues/Arslav/vk-bot)
![GitHub last commit](https://img.shields.io/github/last-commit/Arslav/vk-bot)

Проект для беседы VK игрового сообщества, гильдии World of Warcraft, "[Орден рыцарей Наару](https://vk.com/knaaru)"

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
php vendor/bin/doctrine migration:migrate
```
### Настройка
Создайте файл `.env` в корне проекта и впишите в него свои настройки. Пример можете найти в файле `.env.example`
Разместите ваши изображения в папках `images/f`, `images/pills` для команд "F" и "Дай таблетки"

## Справочник команд и возможностей
Бот распознает команды, которые задаются регулярными выражениями в файле [index.php](index.php).
Например, к боту можно обращаться используя разные формы его имени: `Слава ...`, `Слаааааавааа ...`, `Слава, ...`. Все команды регистронезависимые.

- `Слава кто я?` - выдает случайное прозвище на день
- `Слава кто мы` - выводит список всех прозвищ в беседе
- `Слава дай таблетки` - выдает случайное изображение таблеток
- `ыыыы`/`аааа`/`кряя`/`ряяя`,`аыаы` и д.р. варианты - отвечает аналогичным сообщением
- Если в тексте встретится `F` - отправляет в ответ `F` или изображение
