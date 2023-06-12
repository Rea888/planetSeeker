About: displays weather measurement data for the past 10 years until the current time, on an hourly basis, for five cities: Paris, Moscow, London, Tokyo, and Washington.


To devops:

Dependencies:

-php8.2-gd <br>
-php8.2-xml <br>
-php8.2-mbstring <br>
-php8.2-curl <br>
-php8.2-mysqli <br>


Build steps:

1.step: git clone planetSeeker <br>
2.step: composer install <br>
3.step: make .env file with "given" parameters <br>
4.step: make a Database, called: planetSeeker <br>
5.step: run php artisan migrate <br>
6.step: run php artisan weatherforecast:process
7.step: run php artisan humidityProcess:save
8.step: run php artisan humidity:queue
9.step: run php artisan queue:work --stop-when-empty
10.step: run php artisan humidity:queue
11.step: run php artisan queue:work --stop-when-empty
