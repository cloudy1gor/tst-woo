## Структура
```
/landing - файли з версткою і js/php частиною тз
/woo - тека з темою Wordpress
```

### У теці /landing просто потрібно відкрити index.html
### У теці /woo відкрити консоль та виконати ряд команд:
```sh
cp env.example .env

docker-compose build --no-cache

docker-compose up -d
```

Тепер проект доступний за адресою: `http://localhost:8001`.

* `woo/src` – тека з темою Wordpress
* `woo/dump` – тека з database dumps