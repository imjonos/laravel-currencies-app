<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Test App 

Laravel 8 test app providing currency rates.

![Example](https://i.imgur.com/nvtmsYi.png)

![Example](https://i.imgur.com/ZqMkfeD.png)

## Used packages

Laravel Passport, DomCrawler, Guzzle

## Install

1. git clone https://github.com/imjonos/laravel-currencies-app.git ./
2. composer install
3. npm install
4. npm run dev/prod
5. copy .env.example to .env
6. Configure DB
7. php artisan key:generate
8. php artisan migrate
9. php artisan db:seed 
10. Please check access to ./storage and ./bootstrap directories

## Using

1. Add new user: php artisan users:create
2. Import currencies: php artisan currencies:import
3. Login url: /login

##API

Based on https://jsonapi.org. 

Used for authorization: 

1. Password Grant Tokens https://laravel.com/docs/8.x/passport#password-grant-tokens
2. CreateFreshApiToken middleware https://laravel.com/docs/8.x/passport#consuming-your-api-with-javascript

Methods:
1. Get currency resources: Get /api/v1/currencies
2. Get currency resource: Get /api/v1/currencies/{id}

![Example](https://i.imgur.com/x99tM7f.png)
