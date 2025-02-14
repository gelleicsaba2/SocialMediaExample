# Instructions

* Run the following command:
```
npm install && npm run build
```

* Change the database params in the .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=socialmedia
DB_USERNAME=yourName
DB_PASSWORD=yourPassword
```


* Run the laravel migration and seed with following command:
```
php artisan migrate:fresh --seed
```
There are also test data in the 'TestDataSeeder.php'. If you dont want these,
comment the lines, then run the migrate:fresh command.

* Run the laravel app with:
```
  php artisan serve
```

View the http://127.0.0.1:8000/ in the browser (, or http://yourdomain:port if you have
changed the .env host/port etc...)

The project code created with Breeze (starter kit), and the email confirmation is disabled.
