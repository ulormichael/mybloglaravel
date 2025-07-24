composer create-project "laravel/laravel:^10.0" example-app     # To create a new Laravel project
# Laravel Artisan Commands

## Initial Project Setup & Local Development
composer install        # Installs project dependencies from composer.json
php artisan serve       # Starts the built-in PHP development server
php artisan key:generate # Sets the application key in your .env file (run this once after composer install on a new project)
php artisan storage:link # Creates a symbolic link from public/storage to storage/app/public (to make uploaded files accessible via web)
php artisan --version   # Displays the Laravel Framework version
php artisan env         # Displays the current framework environment (e.g., local, production)
php artisan about       # (Laravel 9+) Displays basic information about your application, environment, and drivers.

## Database Migrations
php artisan migrate                     # Runs pending database migrations
php artisan make:migration create_users_table # Creates a new migration file (e.g., for a 'users' table)
php artisan make:migration my_new_columns --table=users # Creates a migration for adding new columns to the 'users' table
php artisan migrate:fresh               # Drops all tables and re-runs all migrations (useful in development)
php artisan migrate:fresh --seed        # Drops all tables, re-runs migrations, and runs seeders
php artisan migrate:rollback            # Rolls back the last database migration
php artisan migrate:reset               # Rolls back all database migrations
php artisan migrate:status              # Shows the status of each migration

## Generating Code (Make Commands)
php artisan make:controller UserController     # Creates a new controller class (e.g., UserController - you have this!)
php artisan make:controller PostController --resource # Creates a resourceful controller with common CRUD methods
php artisan make:model Post                     # Creates a new Eloquent model class (e.g., Post)
php artisan make:model Post -mcf                # Creates a Model (Post) and corresponding migration (-m), factory (-f), and resourceful controller (-c)
php artisan make:middleware SetAuthorizationHeaderFromCookie   # Creates a new middleware class
php artisan make:request StorePostRequest       # Creates a new form request class (for request validation)
php artisan make:seeder UsersTableSeeder        # Creates a new database seeder class
php artisan make:factory PostFactory            # Creates a new model factory (for generating fake data)
php artisan make:command SendEmails             # Creates a new Artisan console command
php artisan make:event PodcastProcessed         # Creates a new event class
php artisan make:listener SendPodcastNotification # Creates a new event listener class
php artisan make:notification InvoicePaid       # Creates a new notification class
php artisan make:policy PostPolicy --model=Post # Creates a policy class for authorization, optionally for a model
php artisan make:test UserTest                  # Creates a new feature test
php artisan make:test UserTest --unit           # Creates a new unit test
php artisan make:job ProcessPodcast            # Creates a new job class (for queued tasks)

## Database Seeding
php artisan db:seed                     # Runs all database seeders
php artisan db:seed --class=UsersTableSeeder # Runs a specific seeder class

## Routing
php artisan route:list                  # Lists all registered routes in your application (very useful for debugging)
php artisan route:cache                 # Creates a route cache file for faster route registration (use in production)
php artisan route:clear                 # Clears the route cache file (use in development when routes change)

## Caching (Important for Performance)
php artisan cache:clear                 # Flushes the application cache (e.g., data cache)
php artisan config:cache                # Creates a cache file for faster configuration loading (use in production)
php artisan config:clear                # Clears the configuration cache (use in development when .env or config files change)
php artisan view:clear                  # Clears all compiled view files
php artisan view:cache                  # Compiles all Blade views for faster rendering (use in production)
php artisan event:cache                 # Discovers and caches application events and listeners (use in production)
php artisan event:clear                 # Clears the cached events and listeners

## Optimization
# php artisan optimize                  # Deprecated in newer Laravel versions. Caches bootstrap files, config, and routes.
                                        # Prefer individual cache commands like config:cache and route:cache.
php artisan optimize:clear              # Clears all cached files (config, routes, views, compiled, events)

## Interactive Shell (REPL)
php artisan tinker                      # Opens an interactive shell (REPL) for your application. Great for testing Eloquent queries, services, etc.

## Maintenance Mode
php artisan down                        # Puts the application into maintenance mode
php artisan up                          # Brings the application out of maintenance mode

## Queueing (For background tasks)
php artisan queue:work                  # Starts a queue worker to process jobs from the queue
php artisan queue:failed                # Lists all failed queue jobs
php artisan queue:retry <ID|all>        # Retries a failed queue job by ID or all failed jobs
php artisan queue:table                 # Creates a migration for the failed_jobs database table (run once)

## Listing Commands and Getting Help
php artisan list                        # Lists all available Artisan commands
php artisan help <command_name>         # Displays help for a specific command (e.g., php artisan help migrate)


<!-- request objects samples -->
<?php
use Illuminate\Http\Request;
$ipAddress = $request->ip();
$method = $request->method(); // e.g., "GET", "POST"
$path = $request->path();     // e.g., "users/123"
$request->header('Authorization');
$contentType = $request->header('Content-Type');
$request->file('image')
?>
<!-- sample migration file -->
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing primary key column named 'id'
            $table->string('name'); // Creates a string column named 'name'
            $table->string('email')->unique(); // Creates a unique string column named 'email'
            $table->timestamp('email_verified_at')->nullable(); // Creates a nullable timestamp column for email verification
            $table->string('password'); // Creates a string column for the password
            $table->rememberToken(); // Adds a token column for "remember me" functionality
            $table->timestamps(); // Adds created_at and updated_at timestamp columns
        });
    }
}
?>


<!-- Diferent model schema datatype -->
<?php
$table->string('name');
$table->text('content');
$table->longtext('description'); // For larger text fields
$table->integer('age')->unique()->default(18); // Adds an integer column with a default value and unique constraint
$table->bigInteger('views')->unsigned(); // Adds an unsigned big integer column
$table->float('height')->nullable(); // Adds a nullable float column
$table->boolean('is_active')->default(true); // Adds a boolean column with a default value
$table->timestamps()->current(); // Adds created_at and updated_at columns
$table->softDeletes(); // Adds a deleted_at column for soft deletes
$table->json('settings'); // Adds a JSON column for storing settings
$table->enum('status', ['active', 'inactive', 'pending']); // Adds an ENUM column for status
?>

<!-- sample routes -->
<?php
use Illuminate\Support\Facades\Route;
// generic route
Route::get("/users", function () {
    return "Hello World";
})
// route with controller
use App\Http\Controllers\UserController;
Route::get("/users", [UserController::class, 'getUsers']);

// route with middleware and controller
Route::middleware('auth:sanctum')->get("/users", [UserController::class, 'createUser']);

// sample route with parameters
// Route with a parameter
Route::get('/users/{id}', function ($id) {
    return "User ID: " . $id;
});

// route with multiple parameters
Route::get("/users/email/{email}/id/{id}", [UserController::class, 'getUserByEmailAndId']);
?>

<!-- useful functions -->
<?php
function getImageInfo($image){
    if (!$image) {
        return null;
    }

    return [
        'original_name' => $image->getClientOriginalName(),
        'mime_type'     => $image->getMimeType(),
        'size_bytes'    => $image->getSize(),
        'extension'     => $image->getClientOriginalExtension(),
        'tmp_path'      => $image->getRealPath(),
    ];
}

 public function slugify($title){
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
    return strtolower(trim($slug, '-'));
}
?>
<!-- useful controller functions -->
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
// to create new user
public function createUser(Request $request)
    {
        $user = User::create([ //here the User is a model
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);
        return response()->json($user, 201);
    }

// to get all users
public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

// to get user by id
function getUserById($id) {
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }
    return response()->json($user);
}

// to update user
 public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);
        return response()->json($user);
    }

// to delete a user by id
public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

// to get user by email
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

// to get user by email and id
    public function getUserByEmailAndId($email, $id)
    {
        $user = User::where('email', $email)->where('id', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

// login and create token
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        // Create a token name, e.g., 'api-token' or based on user agent
        $tokenName = 'api_token_for_user_' . $user->id;
        $token = $user->createToken($tokenName)->plainTextToken;

        // Cookie lifetime in minutes (e.g., 1 day)
        $cookieLifetime = 1440; // 24 * 60

        return response()->json([
            'user' => $user,
            'message' => 'Login successful'
        ])->cookie(
            'api_auth_token', // Cookie name
            $token,             // Token value
            $cookieLifetime,    // Expiration time in minutes
            '/',                // Path
            null,               // Domain (null for current domain)
            config('session.secure_cookie', false), // Secure (true if HTTPS)
            true,               // HttpOnly
            false,              // Raw
            config('session.same_site', 'lax') // SameSite attribute
        );
    }

// logout and delete token
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Successfully logged out'])
        ->withoutCookie('api_auth_token'); // Clear the cookie
}

// create operations with validations and functions
  public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageInfo = $this->getImageInfo($request->file('image'));
        $userId = $request->user()->id;
        $post = Post::create([
            'user_id' => $userId,
            'slug' => $this->slugify($request->title),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->file('image') ? $request->file('image')->store('uploads', 'public') : null,
        ]);

        return response()->json($post, 201);
    }

    // update operation with validation
public function updatePost(Request $request, $id){
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageInfo = $this->getImageInfo($request->file('image'));

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imageInfo ? json_encode($imageInfo) : null,
        ]);

        return response()->json($post);
    }
    
// update post with patch
  public function updatePost(Request $request, $id){
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (isset($validatedData['title'])) {
            $validatedData['slug'] = $this->slugify($validatedData['title']);
        }

        if ($request->hasFile('image')) {
            if ($post->image) { \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image); }
            $validatedData['image'] = $request->file('image')->store('uploads', 'public');
        } elseif ($request->has('image') && $request->input('image') === null) {
            $validatedData['image'] = null;
        }

        $post->update($validatedData);
        return response()->json($post->fresh());
    }

?>

<!-- Sample Model -->
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'content',
        'user_id',
        'image',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
?>
<!-- sample middleware -->
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAuthorizationHeaderFromCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if an Authorization header is already set and if the cookie exists
        if (!$request->bearerToken() && $request->hasCookie('api_auth_token')) {
            $token = $request->cookie('api_auth_token'); //get the cookie by name
            if ($token) {
                // set the cookie as the Bearer token in the Authorization header
                $request->headers->set('Authorization', 'Bearer ' . $token);
            }
        }

        return $next($request);
    }
}


// this is the middleware registration in app/Http/Kernel.php
'auth.cookie.token' => \App\Http\Middleware\SetAuthorizationHeaderFromCookie::class,