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

## How It All Works Together

1. When a user registers, they're automatically assigned the "user" role
2. When they go to the dashboard, the system checks their role
3. If they're an admin, they get sent to the admin dashboard
4. If they try to access pages they shouldn't, the middleware blocks them
5. Users can manage their accounts, including deleting them when needed

## What's Next

In the next phase, we'll add travel packages that users can browse and book.

> **Note**: Laravel 12 doesn't use Kernel.php files anymore to reduce unnecessary code.

