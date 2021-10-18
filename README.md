# Interview Test (E-commerce Test)

## To get started follow the next commands

#### Clone the repository
```
git clone https://github.com/Jesus-RA/e-commerce-test.git
```

#### Install all PHP and Laravel dependencies
```
composer install
```

#### Install all JavaScript dependencies
```
npm install
```

#### Generate project key
```
php artisan key:generate
```

#### Execute all tests
```
php artisan test
```

#### Configure sqlite database
Copy .env.example file and replace the DB configuration with the next.
```
DB_CONNECTION=sqlite
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=e_commerce_test
#DB_USERNAME=root
#DB_PASSWORD=
```

#### Seed data to watch how the project look with data
```
php artisan db:seed
```

#### Start the servers

##### PHP Serve
```
php artisan serve 
```

##### Webpack serve
```
npm run watch
```

## Admin credentials
```
{
    email: 'admin@webforcehq.com',
    password: 'webforce'
}
```