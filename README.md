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

#### Create .env file
* Copy .env.example file and rename it to .env

#### Generate project key
```
php artisan key:generate
```

#### Execute all tests
```
php artisan test
```

#### Configure sqlite database
* In .env file replace the DB configuration with the next.
```
DB_CONNECTION=sqlite
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=e_commerce_test
#DB_USERNAME=root
#DB_PASSWORD=
```

* Create database.sqlite file in ./database
* Execute command `php artisan migrate` to create all the database tables

#### Seed data to watch how the project look with data
Before seeding data make sure you have in your .env file APP_URL configured
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

#### To upload images for products set the environment variable
```
MEDIA_DISK="products"
```

## Admin credentials
```
{
    email: 'admin@webforcehq.com',
    password: 'webforce'
}
```