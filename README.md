# PHP_Laravel12_Permission_Driven_UI_Engine
```php
Laravel 12 based web application demonstrating a Permission Driven UI Engine using Roles & Permissions.
```

# Step 1: Install Laravel 12 – Create Project
Open Terminal / CMD:
```php
composer create-project laravel/laravel:^12.0 PHP_Laravel12_Permission_Driven_UI_Engine
```
Move to project folder:
```php
cd PHP_Laravel12_Permission_Driven_UI_Engine
```
Generate application key:
```php
php artisan key:generate
```
# Step 2: Setup Database (.env File)
Open .env file and configure database credentials:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=laravel12_permission_ui
DB_USERNAME=root
DB_PASSWORD=
```
Create database in MySQL / phpMyAdmin:
```php
CREATE DATABASE laravel12_permission_ui;
```
Run default migrations:
```php
php artisan migrate
```
# Step 3: Install Authentication (Laravel Breeze)
Install Breeze:
```php
composer require laravel/breeze --dev
```
Install Blade authentication scaffolding:
```php
php artisan breeze:install blade
```
Run migrations:
```php
php artisan migrate
```
Install frontend assets:
```php
npm install
npm run build
```
# Explanation
```php
- Adds Login, Register, Dashboard
- Uses Blade UI
- Required for permission-based access
```
# Step 4: Install Spatie Permission Package
Install package:
```php
composer require spatie/laravel-permission
```
Publish config & migrations:
```php
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```
Run migrations:
```php
php artisan migrate
```
# Step 5: Configure User Model
Path: app/Models/User.php
```php
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```
# Explanation
```php
- Enables role & permission methods
- Required for permission driven UI
```
# Step 6: Create Post Module
Create model & migration:
```php
php artisan make:model Post -m
```
Migration File
```php
Path: database/migrations/xxxx_create_posts_table.php
```
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```
Run migration:
```php
php artisan migrate
```
# Step 7: Configure Post Model
Path: app/Models/Post.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];
}
```
# Step 8: Create Post Controller
Create controller:
```php
php artisan make:controller PostController
```
Path: app/Http/Controllers/PostController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->get()
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index');
    }
}
```
# Step 9: Define Routes with Permission Middleware
Path: routes/web.php
```php
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 POSTS (THIS WAS MISSING)
    Route::resource('posts', PostController::class);
});

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:Admin'])->group(function () {
    Route::get('/users', [UserController::class,'index']);
    Route::post('/users/{user}/role', [UserController::class,'assignRole']);
});

require __DIR__.'/auth.php';
```
# Explanation
```php
- Routes are protected by permissions
- Even direct URL access is blocked if permission missing
```
# Step 10: Blade Permission Driven UI
Create Post View
```php
Path: resources/views/posts/create.blade.php
```
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-xl rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Create New Post
        </h1>

        <form method="POST" action="{{ route('posts.store') }}" class="space-y-5">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>
                <input
                    type="text"
                    name="title"
                    placeholder="Enter post title"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Content
                </label>
                <textarea
                    name="content"
                    rows="5"
                    placeholder="Write your post content..."
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition"
                >
                    Save Post
                </button>
            </div>
        </form>
    </div>

</body>
</html>
```
Posts List View
```php
Path: resources/views/posts/index.blade.php
```
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Posts
            </h2>

            @can('post-create')
                <a
                    href="{{ route('posts.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
                >
                    ➕ Create Post
                </a>
            @endcan
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-sm font-semibold text-gray-700">
                            Title
                        </th>
                        <th class="text-right px-4 py-3 text-sm font-semibold text-gray-700">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800">
                                {{ $post->title }}
                            </td>

                            <td class="px-4 py-3 text-right space-x-3">
                                @can('post-edit')
                                    <a
                                        href="#"
                                        class="text-blue-600 hover:text-blue-800 font-medium"
                                    >
                                        Edit
                                    </a>
                                @endcan

                                @can('post-delete')
                                    <a
                                        href="#"
                                        class="text-red-600 hover:text-red-800 font-medium"
                                    >
                                        Delete
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-gray-500">
                                No posts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
```
# Explanation
```php
- UI buttons appear only if permission exists
- Permission removed → button hidden automatically
```
# Step 11: Create Role & Permission Seeder
Create seeder:
```php
php artisan make:seeder RolePermissionSeeder
```
Path: database/seeders/RolePermissionSeeder.php
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{

    public function run()
    {
        $permissions = [
            'post-create',
            'post-edit',
            'post-delete',
            'post-view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);

        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo(['post-create', 'post-view']);
    }
}
```
# Step 12: Run Laravel 12 Project
Start development server:
```php
php artisan serve
```
Open browser:
Posts Page
```php
http://127.0.0.1:8000/posts
```
<img width="1336" height="664" alt="image" src="https://github.com/user-attachments/assets/dedea580-d884-44e2-acfd-9c69cb19f703" />
```php
http://127.0.0.1:8000/posts/create
```
<img width="1340" height="665" alt="image" src="https://github.com/user-attachments/assets/f7e24e45-6252-4b2f-a1bc-0990f9773c65" />

# Project Folder Structure
```php
PHP_Laravel12_Permission_Driven_UI_Engine
├── app
│   ├── Http
│   │   └── Controllers
│   │       └── PostController.php
│   └── Models
│       ├── User.php
│       └── Post.php
│
├── database
│   └── seeders
│       └── RolePermissionSeeder.php
│
├── resources
│   └── views
│       └── posts
│           ├── create.blade.php
│           └── index.blade.php
│
├── routes
│   └── web.php
│
├── .env
├── artisan
```



