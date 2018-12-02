# tochka-testing-backend

Решение [тестового задания](https://github.com/Life1over/test-task/blob/master/php.md).  
Бэкенд.  
Используется:
```
"laravel/lumen-framework": "5.7.*",
"fzaninotto/faker": "~1.4",
```

Проект хранит данные в sqlite, потребуется php > 7.0 и расширение php-sqlite3.  
База по умолчанию находится в database/database.sqlite (файл создастся автоматически во время генерации задач).  

## Конфиг nginx (для бэкенда и фронтэнда)
```
server {
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;

    server_name localhost;
    root /var/www/tochka-testing-backend/public;
    index index.php index.html index.htm;

    location ~ ^/api {
         try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_pass php-upstream;
        fastcgi_index index.php;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        #fixes timeouts
        fastcgi_read_timeout 600;
        include fastcgi_params;
    }

    location ~ ^/(.*) {
        root /var/www/tochka-testing-frontend/dist;
        try_files /$1 /index.html =404;
    }
}

```

## Установка зависимостей
```
composer install
```

## Генерация задач и создание файла для базы SQLite
Есть два способа — через консольные команды и через GET-запрос.  
Запрос: `GET /api/v1/regenerate`  
Консоль:
```
php artisan migrate:refresh
php artisan generate:tasks
```
