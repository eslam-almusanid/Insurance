# Insurance Broker Platform

This is a Laravel-based insurance broker platform designed to manage users, vehicles, drivers, insurance offers, policies, and payments.
It supports features like new/transfer insurance types, registration types (new, renew, customs card), and a streamlined workflow for offer generation and policy management.

## Features
- **User Management**: Register and manage users with profiles, roles, and permissions.
- **Vehicle & Driver Management**: Store vehicle details and driver information, including violations.
- **Insurance Offers & Policies**: Request, generate, and accept insurance offers; issue policies with new/transfer and new/renew/customs card registration types.
- **Payment Processing**: Handle payments with multiple methods (e.g., Mada, Visa).
- **Notifications & Audits**: Send notifications and log actions for accountability.

## Prerequisites
- PHP 8.1 or higher
- Composer
- PostgreSQL 13 or higher
- Git

## Installation

### 1. Clone the Repository

### 2. Clone the Repository
```bash
composer install
```

### 3. Configure Environment
#### a. Copy the example .env file and update it with your settings:
```bash
cp .env.example .env
```
#### b. Edit .env with your PostgreSQL credentials and database names:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example_app
DB_USERNAME=user_name
DB_PASSWORD=your_password
```
#### c. Generate an application key:
```bash
php artisan key:generate
```


### 4. Set Up PostgreSQL Databases
#### a. Connect to PostgreSQL as a superuser (e.g., postgres):
```bash
psql -U postgres
```
#### b. Run the following SQL commands to create the databases:
```bash
CREATE DATABASE user_db WITH OWNER = postgres ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8' TABLESPACE = pg_default CONNECTION LIMIT = -1;
CREATE DATABASE vehicle_db WITH OWNER = postgres ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8' TABLESPACE = pg_default CONNECTION LIMIT = -1;
CREATE DATABASE insurance_db WITH OWNER = postgres ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8' TABLESPACE = pg_default CONNECTION LIMIT = -1;
CREATE DATABASE shared_db WITH OWNER = postgres ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8' TABLESPACE = pg_default CONNECTION LIMIT = -1;
```
#### c. (Optional) Create a dedicated user:
```bash
CREATE ROLE insurance_user WITH LOGIN PASSWORD 'your_secure_password';
ALTER DATABASE user_db OWNER TO insurance_user;
ALTER DATABASE vehicle_db OWNER TO insurance_user;
ALTER DATABASE insurance_db OWNER TO insurance_user;
ALTER DATABASE shared_db OWNER TO insurance_user;
```
#### d. Update .env with the new user if created.

### 5. Run Migrations
#### a. Run migrations for all databases (We Using Custom Command to run all db migrations):
```bash
php artisan migrate:all --fresh
```


### 6. Start the Development Server
#### a. Run migrations for each database:
```bash
php artisan serve
```
#### b. Visit http://localhost:8000 in your browser.



### 7. Final Structure with Versioning

app/
├── Http/
│   └── Controllers/
│       ├── V1/
│       │   └── UserController.php
│       └── V2/
│           └── UserController.php
├── Repositories/
│   ├── Interfaces/
│   │   └── UserRepositoryInterface.php
│   └── Eloquent/
│       ├── V1/
│       │   └── UserRepository.php
│       └── V2/
│           └── UserRepository.php
├── Providers/
│   ├── AppServiceProvider.php
│   ├── RepositoryServiceProvider.php
│   └── SingletonServiceProvider.php
├── Integrations/
│   ├── Interfaces/
│   │   └── ExternalServiceInterface.php
│   └── Services/
│       └── ServiceName.php
├── Models/
│   └── User.php
├── Services/
│   ├── V1/
│   │   └── UserService.php
│   └── V2/
│       └── UserService.php
routes/
│   ├── V1/
│   │   └── api.php
│   └── V2/
│       └── api.php
### 8. Workflow
https://miro.com/welcomeonboard/VS9SdDJJQ2JkVHVMeVpsQ3dGYkVpNW5lR3BvSnVYRzZoVzFVOUFzNUtHbjI1clpBZHA1MkQ0WTRyVjkrMGk0eWJNTWFzN25NOXhQb3czK1BtalJFejFiVDhydFQ5UG9leWtVMzZYbTBVejRKblMwVGpDbzg5WUFOSTBPWmJzQ3Z3VHhHVHd5UWtSM1BidUtUYmxycDRnPT0hdjE=?share_link_id=815500364907
