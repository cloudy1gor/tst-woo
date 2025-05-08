## Структура
```
/landing - файли з версткою і js/php частиною тз
/woo - тека з файлами для роботи з темою Wordpress
/woo/src/themes/storefront/inc/storefront-woocommerce-customizations.php - файл з кодом для ТЗ
/woo/dump - імпорт бази данних
```

### У теці /landing просто потрібно відкрити index.html
### У теці /woo відкрити консоль та виконати ряд команд:
```sh
cp env.example .env

docker-compose build --no-cache

docker-compose up -d
```

### Тепер потрібно зробити імпорт данних до БД:

```
bash export.sh
```

Тепер проект доступний за адресою: `http://localhost:8001`.
Логін та пароль `admin` для входу в wp-admin

![](/screen.jpg)
![](/screen2.jpg)
![](/screen3.jpg)