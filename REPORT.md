# Travel Booking Application Implementation Report

## What We've Done So Far

We've set up a travel booking website with two types of users: regular users and admins. Here's what we've accomplished:

### 1. User Roles Setup

We created a system to separate admin users from regular users:

- **Role Model**: Created a table to store user roles (`app/Models/Role.php`)
  ```php
  // This model defines what roles exist in our system
  class Role extends Model
  {
      protected $fillable = ['name'];
      
      public function users()
      {
          return $this->hasMany(User::class);
      }
  }
  ```

- **User-Role Connection**: Updated the User model (`app/Models/User.php`) to connect users to roles
  ```php
  // Added this method to check if a user is an admin
  public function isAdmin(): bool
  {
      return $this->role?->name === 'admin';
  }
  ```

### 2. Database Changes

We modified the database to support our user roles:

- Created a `roles` table with a `name` column (admin, user)
- Added a `role_id` column to the `users` table
- Created seeders to automatically add roles and an admin user

### 3. Automatic Role Assignment

We updated the registration process to automatically assign the "user" role to new users:

- Modified `CreateNewUser` class (`app/Actions/Fortify/CreateNewUser.php`):
  ```php
  // Get the 'user' role (default role for new registrations)
  $userRole = Role::where('name', 'user')->first();

  return User::create([
      'name' => $input['name'],
      'email' => $input['email'],
      'password' => Hash::make($input['password']),
      'role_id' => $userRole ? $userRole->id : null, // Assign user role
  ]);
  ```

- Added user role assignment to the UserFactory:
  ```php
  /**
   * Assign the user role to the user.
   */
  public function withUserRole(): static
  {
      return $this->state(function () {
          $userRole = Role::where('name', 'user')->first();
          
          return [
              'role_id' => $userRole ? $userRole->id : null,
          ];
      });
  }
  ```

### 4. Admin Access Control

We built a system to control who can access admin pages:

- **Admin Middleware**: Created a guard (`app/Http/Middleware/AdminMiddleware.php`) that checks if you're an admin
  ```php
  // This code runs before showing admin pages
  // It checks if you're logged in AND you're an admin
  public function handle(Request $request, Closure $next): Response
  {
      if (Auth::check() && Auth::user()->isAdmin()) {
          return $next($request);
      }

      return redirect()->route('dashboard');
  }
  ```

- **Admin Routes**: Set up special paths for admin pages (`routes/web.php`)
- **Admin Dashboard**: Created a special page just for admins (`resources/views/admin/dashboard.blade.php`)

### 5. User Redirection

We made the website smart enough to send users to the right place:

- Regular users go to the normal dashboard
- Admin users automatically go to the admin dashboard
- If regular users try to access admin pages, they get redirected

### 6. Account Management

We simplified the account functionality to focus just on our travel booking needs:

- Updated `DeleteUser` action for cleaner user deletion:
  ```php
  public function delete(User $user): void
  {
      DB::transaction(function () use ($user) {
          $user->deleteProfilePhoto();
          $user->tokens->each->delete();
          $user->delete();
      });
  }
  ```

- Removed all team-related functionality since it's not needed for our travel booking app

### 7. Testing

We wrote tests to make sure everything works:

- Test that regular users can't access admin pages
- Test that admin users can access admin pages
- Test that admin users get redirected to their dashboard
- Test that user accounts can be deleted properly

### 8. Travel Packages Feature

We've added the ability for users to browse travel packages:

- **Travel Package Model**: Created a model (`app/Models/TravelPackage.php`) to store package info:
  ```php
  class TravelPackage extends Model
  {
      protected $fillable = [
          'name',
          'description',
          'destination',
          'price',
          'start_date',
          'end_date',
          'available_slots',
      ];
  }
  ```

- **Database Table**: Created a `travel_packages` table with fields for package details:
  - Package name and description
  - Destination (country)
  - Price per person
  - Start and end dates
  - Number of available slots

- **Sample Data**: Added a seeder (`database/seeders/TravelPackageSeeder.php`) with example travel packages to destinations like Korea, Japan, China, Malaysia, and Australia.

- **User Interface**: Created pages where users can:
  - See a list of all available packages (`resources/views/user/travel-packages/index.blade.php`)
  - View detailed information about each package (`resources/views/user/travel-packages/show.blade.php`)

- **Controller**: Set up a controller (`app/Http/Controllers/User/TravelController.php`) with methods to:
  ```php
  public function index(): View  // Shows all travel packages
  {
      $travelPackages = TravelPackage::all();
      return view('user.travel-packages.index', compact('travelPackages'));
  }

  public function show(TravelPackage $travelPackage): View  // Shows details of one package
  {
      return view('user.travel-packages.show', compact('travelPackage'));
  }
  ```

- **Routes**: Added routes to access these pages:
  ```php
  Route::get('/travel-packages', [TravelController::class, 'index'])->name('travel-packages.index');
  Route::get('/travel-packages/{travelPackage}', [TravelController::class, 'show'])->name('travel-packages.show');
  ```

- **Dashboard Link**: Updated the user dashboard to include a link to browse travel packages.

## What's Next

In the next phase, we'll add the ability for users to book travel packages.

> **Note**: Laravel 12 doesn't use Kernel.php files anymore to reduce unnecessary code.

## Update: Booking System Implementation

We've now added a booking system that lets users book travel packages! Here's what we did:

### 1. Booking Model

We created a `Booking` model (`app/Models/Booking.php`) to store booking information:

```php
class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'travel_package_id',
        'booking_date',
        'status',
        'number_of_travelers',
    ];
    
    protected $casts = [
        'booking_date' => 'datetime',
    ];
    
    // Relationships with User and TravelPackage
}
```

### 2. Booking Database Table

We set up a `bookings` table with these important columns:
- Who made the booking (`user_id`)
- Which travel package they booked (`travel_package_id`)
- When they made the booking (`booking_date`)
- Booking status (`pending`, `confirmed`, `completed`, or `on_hold`)
- How many people are traveling (`number_of_travelers`)

### 3. Booking Controller

We created a controller (`app/Http/Controllers/User/BookingController.php`) with methods that let users:
- See all their bookings
- Create a new booking
- View details of a specific booking

```php
public function myBookings(): View
{
    // Get all bookings for the logged-in user
    $bookings = Auth::user()->bookings()->with('travelPackage')->latest()->get();
    
    return view('user.bookings.index', compact('bookings'));
}
```

### 4. Booking Routes

We added new routes in `routes/web.php` for the booking system:
```php
// Booking Routes
Route::get('/my-bookings', [BookingController::class, 'myBookings'])
    ->name('bookings.my-bookings');
Route::get('/travel-packages/{travelPackage}/book', [BookingController::class, 'create'])
    ->name('bookings.create');
Route::post('/travel-packages/{travelPackage}/book', [BookingController::class, 'store'])
    ->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])
    ->name('bookings.show');
```

### 5. Booking Views

We created three main views for the booking system:
- A page that lists all your bookings (`resources/views/user/bookings/index.blade.php`)
- A form for making a new booking (`resources/views/user/bookings/create.blade.php`)
- A page showing details of one booking (`resources/views/user/bookings/show.blade.php`)

### 6. Booking Process

Here's how the booking process works:
1. You find a travel package you like and click "Book This Package"
2. You enter how many people are traveling
3. The system checks if there are enough available slots
4. If yes, it creates your booking and reduces the available slots
5. You can then see all your bookings on the "My Bookings" page

### 7. Navigation Links

We added easy-to-find links to:
- Browse travel packages
- View your bookings

These links appear in both the main menu and mobile menu.

## Update: Review System Implementation

We've added a review system that lets users leave reviews for travel packages they've completed! Here's what we did:

### 1. Review Model

We created a `Review` model (`app/Models/Review.php`) to store review information:

```php
class Review extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'rating',
        'comment',
        'review_date',
    ];
    
    protected $casts = [
        'review_date' => 'datetime',
    ];
    
    // Relationships with User and Booking
}
```

### 2. Review Database Table

We set up a `reviews` table with these important columns:
- Who left the review (`user_id`)
- Which booking they're reviewing (`booking_id`) 
- A rating from 1-5 stars (`rating`)
- Their written comment (`comment`)
- When they left the review (`review_date`)

### 3. Helper Method for Checking Review Eligibility

We added a helper method to the Booking model to check if a booking can be reviewed:

```php
public function isEligibleForReview()
{
    return $this->status === 'completed' && !$this->review;
}
```

This makes it easy to check if a user can leave a review (the booking must be completed and not already reviewed).

### 4. Review Controller

We created a controller (`app/Http/Controllers/User/ReviewController.php`) with methods that let users:
- Create a new review for completed bookings
- Submit review ratings and comments
- See all their reviews in one place

```php
public function store(Request $request, Booking $booking): RedirectResponse
{
    // Only allow reviews for eligible bookings
    if (!$booking->isEligibleForReview()) {
        return redirect()->route('bookings.show', $booking)
            ->with('error', 'This booking is not eligible for review.');
    }

    // Create the review with rating and comment
    $review = new Review([
        'user_id' => Auth::id(),
        'booking_id' => $booking->id,
        'rating' => $request->rating,
        'comment' => $request->comment,
        'review_date' => now(),
    ]);

    $review->save();
    
    return redirect()->route('bookings.show', $booking)
        ->with('success', 'Thank you for your review!');
}
```

### 5. Review Routes

We added new routes in `routes/web.php` for the review system:
```php
// Review Routes
Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/my-reviews', [ReviewController::class, 'index'])->name('reviews.index');
```

### 6. Review Views

We created two main views for the review system:
- A page for submitting new reviews (`resources/views/user/reviews/create.blade.php`) 
- A page showing all your reviews (`resources/views/user/reviews/index.blade.php`)

We also updated:
- The bookings list to show review status (`resources/views/user/bookings/index.blade.php`)
- The booking details page to show review or review option (`resources/views/user/bookings/show.blade.php`) 

### 7. Star Rating System

We made a nice star rating system that:
- Shows empty stars that you can click to rate (1-5)
- Turns the stars yellow as you hover over them
- Updates immediately when you click
- Shows filled stars for existing reviews

### 8. Navigation Link

We added a "My Reviews" link in both the main menu and mobile menu so users can easily find all their reviews in one place.

## How It All Works Together

1. You log in to your account
2. You browse available travel packages
3. When you find one you like, you book it by specifying how many people
4. The system creates your booking and shows it in your "My Bookings" list
5. You can click on any booking to see more details about it
6. If your booking is completed, you have the option to leave a review
7. You can rate your experience with stars and leave a comment
8. Your review will be visible in your account and helps other users

The system ensures that all parts work seamlessly together, providing a smooth travel booking experience.

