# Sample-CRUD-with-Yajra-Datatables

Sample laravel app with Yajra Datatables and CRUD using Eloquent and Ajax

1. After cloning this repo:
    - composer install     // To install depedencies and Yajra datatables

2. Update .env.example file for the database connection, edit these line and SAVE as .env,
    create a database first if you don't have database for this sample project :
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=homestead
    DB_PASSWORD=secret
    ```
3. Generate app key
    - php artisan key:generate

4. Insert tables (I already create a migration file for product table)
    - php artisan migrate

5. Run the server. Try to register first so you will be able to log in
    - php artisan serve

6. On the dashboard, you can see the listing, create, update and delete data.


Added files or code in files
1. Use pre-built authentication controllers
    -php artisan make:auth

2. Create a Product model and migration
    -php artisan make:model Product --migration

3. On the database/migrations folder, find the create_products_table.php and update Schema create:
    ```
    Schema::create('products', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('name');
        $table->float('price');
        $table->timestamps();
    });
    ```

4. On the app folder, open Product.php and update the Product model:
    class Product extends Model
    {
        /**
        * The attributes that are mass assignable.
        *
        * @var array
        */
        protected $fillable = [
            'name', 'price'
        ];
    }

4. Create user, password and product table in the database:
    -php artisan migrate

5. Open composer.json and add this to require:
    - "yajra/laravel-datatables": "^1.0",
    - "yajra/laravel-datatables-oracle": "^9.0"

6. HomeController.php
7. home.blade.php
