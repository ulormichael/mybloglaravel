// filtering with eloquent
use App\Models\User;

// Get users with the email 'john.doe@example.com'
$users = User::where('email', 'john.doe@example.com')->get();


// Users with age between 18 and 30
$users = User::whereBetween('age', [18, 30])->get();

// filtering with operators
// Users older than 25
$users = User::where('age', '>', 25)->get();

// Users with names starting with 'A'
$users = User::where('name', 'like', 'A%')->get();

$posts = Post::where('title', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%')
            ->get();

// Users with a specific role (assuming a 'role' column)
$users = User::where('role', 'admin')->get();

// Users NOT equal to a certain value
$users = User::where('status', '!=', 'inactive')->get();

// multiple conditions
// Users with age greater than 25 and email with "john.doe@example.com" and name with "John"
$users = User::where('age', '>', 25)
    ->where('email', 'john.doe@example.com')
    ->where('name', 'John')->get();

// Users with name 'John' AND age greater than 20
$users = User::where('name', 'John')
             ->where('age', '>', 20)
             ->get();

// Users with name 'John' OR email 'jane.doe@example.com'
$users = User::where('name', 'John')
             ->orWhere('email', 'jane.doe@example.com')
             ->get();

//Mixing AND and OR with grouping
$users = User::where('status', 'active')
            ->where(function ($query) {
                $query->where('name', 'like', 'A%')
                      ->orWhere('email', 'like', '%@example.com');
            })->get();

// filtering by date
// Users created on a specific date
$users = User::whereDate('created_at', '2023-10-27')->get();

// Users created in a specific month
$users = User::whereMonth('created_at', '10')->get();

// Users created between two dates
$users = User::whereBetween('created_at', ['2023-01-01', '2023-12-31'])->get();

// filtering with whereIn and whereNothing
// Users with specific IDs
$users = User::whereIn('id', [1, 2, 3])->get();

// Users NOT with specific IDs
$users = User::whereNotIn('id', [4, 5])->get();

// filtering with relations
// Get users who have published posts
$users = User::has('posts')->get();

// Get users who have published more than 5 posts
$users = User::has('posts', '>', 5)->get();

// Get users who have posts with a specific title
$users = User::whereHas('posts', function ($query) {
    $query->where('title', 'My First Post');
})->get();

// pagination
$users = User::where('status', 'active')->paginate(15); // 15 users per page