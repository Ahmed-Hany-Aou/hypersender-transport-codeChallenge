Hypersender Filament Coding Challenge
This repository contains the solution for the Hypersender Filament Coding Challenge. The project is a transportation management application built with Laravel and Filament v3, designed to manage companies, drivers, vehicles, and trips, with a core focus on preventing scheduling conflicts.

Core Features
Modern UI: A customized Filament theme with an improved user interface, including a collapsible header toggle and colored status badges.

CRUD Management: Full Create, Read, Update, and Delete functionality for all core resources (Companies, Drivers, Vehicles, Trips, Promos).

Advanced Validation: Robust, real-time validation to ensure data integrity, including unique constraints on edit, logical date ranges, and automatic deactivation of expired promos.

Overlap Prevention: A custom, reusable validation rule that reliably prevents drivers or vehicles from being double-booked on overlapping trips.

Live KPI Dashboard: A real-time dashboard displaying key metrics like active trips, available drivers/vehicles, and trips completed this month.

Manager Availability Checker: A custom utility page where managers can select a date range and instantly view all available drivers and vehicles.

Performance Optimized: The application is optimized to prevent N+1 query issues using eager loading on all resource tables.

Intelligent Caching: The dashboard KPIs are cached for performance and automatically cleared via an Observer whenever trip data changes, ensuring data is both fast and accurate.

Comprehensive Test Suite: The application is backed by a thorough Pest test suite, covering all critical business logic with over 80% coverage.

Bonus Feature: Real-Time WhatsApp Notifications: The application is integrated with the Hypersender WhatsApp API. It automatically sends a WhatsApp notification to a manager whenever a new trip is scheduled, showcasing a real-world use case for the company's own product.

Setup Instructions
To get the project up and running on your local machine, please follow these steps.

1. Clone the Repository

git clone <your-repository-url>
cd hypersender-transport-codeChallenge

2. Install Dependencies

composer install
npm install

3. Environment Configuration

# Copy the example environment file
cp .env.example .env

# Generate a new application key
php artisan key:generate

4. Database Setup
Create a database for the project (e.g., hypersender_db) and update your .env file with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hypersender_db
DB_USERNAME=root
DB_PASSWORD=

5. Hypersender API Configuration (For Bonus Feature)
To enable the WhatsApp notifications, add your Hypersender credentials and a target phone number to your .env file:

HYPERSENDER_INSTANCE_ID=your_instance_id
HYPERSENDER_API_TOKEN=your_api_token
MANAGER_WHATSAPP_NUMBER=201065232774

6. Run Migrations and Seed the Database
This command will set up your database schema and populate it with a rich set of realistic test data.

php artisan migrate:fresh --seed

7. Compile Frontend Assets
In one terminal, run the Vite development server:

npm run dev

8. Serve the Application
In a separate terminal, run the Laravel server:

php artisan serve

You can now access the application at http://127.0.0.1:8000. The Filament panel is available at /admin.

Login Email: admin@hypersender.com

Login Password: password

Key Design Decisions
A few key architectural decisions were made to meet the challenge's requirements for correctness, performance, and maintainability.

Trip Overlap Validation
The core business logic to prevent double-bookings was encapsulated in a custom OverlapRule.php.

Why: This approach keeps the complex validation logic out of the Filament resource file, making the code clean, reusable, and independently testable.

How: The rule directly queries the trips table for conflicts within a given time window, ensuring maximum efficiency. It is integrated into the TripResource form with live() inputs to provide instant validation feedback to the user.

Dashboard Caching Strategy
To ensure the dashboard is both fast and accurate, a multi-layered caching strategy was implemented.

Why: Calculating KPIs on every page load is inefficient. Caching provides a near-instant experience for the user while ensuring data remains fresh.

How: The DashboardStats widget uses Cache::remember() to store results for 1 minute. To solve the stale data problem, a TripObserver was created. This observer automatically clears the specific cache key (Cache::forget('dashboard_kpis')) whenever a trip is created, updated, or deleted, ensuring the dashboard reflects changes made within the application in real-time.

WhatsApp Notification Architecture
The "extra mile" feature was implemented using Laravel's native Notification system for a clean and professional architecture.

Why: This decouples the notification logic from the main application flow, making the system more maintainable and scalable.

How: A custom HypersenderChannel was created to handle the API communication. A NewTripScheduled notification class defines the message content, and a TripObserver triggers the notification asynchronously when a new trip is created.

Assumptions Made
The status of a Driver or Vehicle (e.g., 'available', 'on-trip') is assumed to be managed manually by the user. The current implementation does not automatically change a driver's status when they are assigned to a trip.

The default trip duration and status values are generated randomly by the database seeder for demonstration purposes.
