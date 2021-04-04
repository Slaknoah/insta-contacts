# i-Contacts
i-Contacts - менеджер контактов

## Фреймворки
- Laravel 8.12
- NuxtJS 2.15.3

## Установка
Перед установкой убедитесь, что на вашем компьютере установлено следующее
- Docker 
- Node JS

```bash
# Клонировать проект
$ git clone git@github.com:Slaknoah/insta-contacts.git

# Перейти в папку проекта
$ cd insta-contacts

# Получить подмодули
$ git submodule update --init --recursive
```
#### Установка API
```bash
# Перейти в папку api (.../insta-contact/api)
$ cd api

# Копировать файл .env
$ cp .env.example .env

# Перейти в папку laradock (.../insta-contact/api/laradock)
$ cd laradock

# Копировать файл .env
$ cp env-example .env

# Запустить докер
$ docker-compose up -d nginx mysql
$ docker-compose exec workspace bash
```
Введите следующие команды в открывшемся bash
```bash
# Установить ( dependencies )
$ composer install

# Миграция
$ php artisan migrate:fresh --seed

$ exit
```

#### Установка Frontend
```bash
# Перейти в папку frontend  (.../insta-contacts/frontend)
$ cd frontend

# Копировать файл .env
$ cp env-example .env

# Установить ( dependencies )
$ npm install

# Запуск
$ npm run dev
```
Загрузить [i-Contacts](http://localhost:4000)

### Демо-пользователь
- Эл. адрес: user@gmail.com
- Пароль: password

## Лицензия

[MIT](https://opensource.org/licenses/MIT)