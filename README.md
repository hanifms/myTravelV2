# Travel Booking Application

A robust travel booking platform built with Laravel 12, featuring role-based access control, travel package management, booking system, and review functionality.

## Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [User Roles and Permissions](#user-roles-and-permissions)
- [Database Schema](#database-schema)
- [Security Implementations](#security-implementations)
- [Screenshots](#screenshots)
- [License](#license)

## Features

### For Users
- **Account Management**: Register, login, and manage profile details
- **Travel Package Browsing**: View all available travel packages with details
- **Booking System**: Book travel packages and track booking status
- **Reviews & Ratings**: Leave reviews and ratings for completed travels
- **Booking History**: View history of all bookings with status information

### For Administrators
- **User Management**: View, edit, and manage user accounts
- **Travel Package Management**: Create, update, and delete travel packages
- **Booking Management**: Update booking statuses and view all bookings
- **Review Monitoring**: View all user reviews across the platform

## System Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or SQLite
- Laravel requirements (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/travel-booking-app.git
   cd travel-booking-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies and build assets**
   ```bash
   npm install && npm run dev
   ```

4. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure the database**
   
   Edit the `.env` file to set your database connection details:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=travel_booking
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   
   For SQLite (simpler setup):
   ```
   DB_CONNECTION=sqlite
   # Comment out or remove other DB_* entries
   ```
   Then create the database file:
   ```bash
   touch database/database.sqlite
   ```

6. **Run migrations and seed the database**
   ```bash
   php artisan migrate --seed
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   
   Open your browser and navigate to `http://localhost:8000`

### Default Admin Account

After seeding the database, you can use the following credentials to login as admin:
- Email: admin@example.com
- Password: password

## Project Structure

The application follows Laravel's MVC architecture:

### Key Directories:
- **app/Models/**: Contains Eloquent models for User, TravelPackage, Booking, Review, etc.
- **app/Http/Controllers/**: Contains controllers separated by user role (Admin/User)
- **app/Http/Middleware/**: Contains middleware like AdminMiddleware for route protection
- **resources/views/**: Contains Blade templates organized by feature and user role
- **routes/web.php**: Contains all web routes structured by user role
- **database/migrations/**: Contains database schema definitions
- **database/seeders/**: Contains data seeders for initial application data

## User Roles and Permissions

### Regular Users
- Can view and book travel packages
- Can view their booking history
- Can leave reviews for completed travels
- Cannot access admin features

### Administrators
- Full CRUD access to user management
- Full CRUD access to travel package management
- Can update booking statuses
- Can view all user reviews

## Database Schema

The application uses several interrelated tables:

- **users**: Stores user account information
- **roles**: Defines user roles (admin, user)
- **travel_packages**: Stores travel package details
- **bookings**: Records bookings made by users
- **reviews**: Stores user reviews for completed bookings

Key relationships:
- User has many Bookings
- User has many Reviews
- Booking belongs to a User and a TravelPackage
- Review belongs to a User and a Booking

## Security Implementations

- **Authentication**: Secure authentication via Laravel Jetstream
- **Authorization**: Role-based access control for protected routes
- **CSRF Protection**: Protection against cross-site request forgery
- **SQL Injection Protection**: Use of Eloquent ORM and prepared statements
- **XSS Protection**: Blade template engine escapes output by default

## Screenshots

(Add screenshots of your application here)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
