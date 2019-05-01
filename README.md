Laravel sample CRUD using Eloquent with Yajra Datatables

Requirements:
Composer
npm

1. After cloning this git:
    - composer install     //// To install depedencies and Yajra datatables

2. Update .env.example file for the database connection, edit these line and SAVE as .env,
    create a database first if you don't have database for this sample project :

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=homestead
    DB_PASSWORD=secret

3. Generate app key
    - php artisan key:generate

4. Insert tables (I already create a migration file for product table)
    - php artisan migrate

5. Run the server. Try to register first so you will be able to log in
    - php artisan serve

6. On the dashboard, you can see the listing, create, update and delete data.


1. Install laravel, two ways
    :Via Laravel Installer (Prerequisite: Composer)
        -composer global require laravel/installer
        -laravel new <app name>

    :Via Composer Create-Project (Prerequisite: Composer)
        -composer create-project --prefer-dist laravel/laravel <app name>

3. Create a database and name it laravel_sample_crud: (Prerequisite: Database server)

3. Update .env file for the database connection, edit these line on .env :
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_sample_crud
    DB_USERNAME=homestead
    DB_PASSWORD=secret

4. Use pre-built authentication controllers
    -php artisan make:auth

5. Create a Product model and migration
    -php artisan make:model Product --migration

6. On the database/migrations folder, find the create_products_table.php and update Schema create:
    Schema::create('products', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('name');
        $table->float('price');
        $table->timestamps();
    });

7. On the app folder, open Product.php and update the Product model:
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

8. Create user, password and product table in the database:
    -php artisan migrate

9. Run the laravel app:
    -php artisan serve

10. Try now to register a user.

11. Open composer.json and add to this to require:
    - "yajra/laravel-datatables": "^1.0",
    - "yajra/laravel-datatables-oracle": "^9.0"

12. Install yajra datatables:
    - composer update

13. In App/Http/Controller, open HomeController and import these:
    - use App\User;                           // To get Users data
    - use App\Product;                        // To get Products data
    - use Yajra\Datatables\Datatables;        // To use Yajra datatables
    - use Illuminate\Support\Facades\Auth;    // To get user logged in data
