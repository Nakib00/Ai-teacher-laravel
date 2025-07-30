# AI Teacher - Laravel API

This is the backend API for the AI Teacher project, built with Laravel 10. It handles user registration, authentication using JWT (JSON Web Tokens), and the generation of secure tokens for connecting to a LiveKit video room.

## 📌 Prerequisites

Before you begin, ensure you have the following installed on your system:

  * **PHP \>= 8.1**
  * **Composer**
  * **A database server** (e.g., MySQL, MariaDB)
  * **Git**

## 🚀 Setup Instructions

Follow these steps to get the project up and running on your local machine.

### 1\. Clone the Repository

First, clone the project from your repository.

```bash
git clone <your-repository-url>
cd ai-teacher-laravel
```

### 2\. Install Dependencies

Install the required PHP packages using Composer.

```bash
composer install
```

### 3\. Create the Environment File

Copy the example environment file and generate your application key.

```bash
cp .env.example .env
php artisan key:generate
```

### 4\. Configure Your Environment (`.env`)

Open the `.env` file and configure your database connection and add your LiveKit API credentials.

```env
# .env

# --- Database Configuration ---
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_teacher_db
DB_USERNAME=root

DB_PASSWORD=mir0188_2024

# --- LiveKit Credentials ---
LIVEKIT_API_KEY=your_livekit_api_key
LIVEKIT_API_SECRET=your_livekit_api_secret
```

> **Note:** Make sure you create a database named `ai_teacher_db` (or your chosen name) in your database management tool.

### 5\. Generate JWT Secret

Create the secret key required for JWT authentication.

```bash
php artisan jwt:secret
```

### 6\. Run Database Migrations

Create the `users` table in your database by running the migration files.

```bash
php artisan migrate
```

## ▶️ Running the Application

To start the local development server, run the following command:

```bash
php artisan serve
```

Your API will be available at `http://127.0.0.1:8000`.

-----

## ⚙️ API Endpoints

All API endpoints are prefixed with `/api`.

### **Register a New User**

Creates a new user account and returns authentication tokens.

  * **URL:** `/api/register`
  * **Method:** `POST`
  * **Headers:**
      * `Accept: application/json`
  * **Body (raw, JSON):**
    ```json
    {
        "name": "Test User",
        "email": "test@example.com",
        "phone": "1234567890",
        "address": "123 Test Street",
        "password": "password123"
    }
    ```
  * **Success Response (200 OK):**
    ```json
    {
        "success": true,
        "status": 200,
        "message": "Registration successful",
        "data": {
            "user": {
                "user_id": 1,
                "name": "Test User",
                "email": "test@example.com",
                "token": "your_jwt_token",
                "livekit_token": "your_livekit_token",
                "room": "user_1"
            }
        },
        "errors": null
    }
    ```

### **Login an Existing User**

Authenticates a user and provides new tokens.

  * **URL:** `/api/login`
  * **Method:** `POST`
  * **Headers:**
      * `Accept: application/json`
  * **Body (raw, JSON):**
    ```json
    {
        "email": "test@example.com",
        "password": "password123"
    }
    ```
  * **Success Response (200 OK):**
    ```json
    {
        "success": true,
        "status": 200,
        "message": "Login successful",
        "data": {
            "user": {
                "user_id": 1,
                "name": "Test User",
                "email": "test@example.com",
                "token": "your_new_jwt_token",
                "livekit_token": "your_new_livekit_token",
                "room": "user_1"
            }
        },
        "errors": null
    }
    ```
  * **Error Response (401 Unauthorized):**
    ```json
    {
        "success": false,
        "status": 401,
        "message": "Invalid email or password",
        "data": null,
        "errors": {
            "error": "Invalid email or password"
        }
    }
    ```

### **Generate LiveKit Token**

Generates a new LiveKit token for an authenticated user. This is a protected route.

  * **URL:** `/api/token`
  * **Method:** `POST`
  * **Authorization:**
      * Type: `Bearer Token`
      * Token: (The `token` received from the login or register endpoint)
  * **Headers:**
      * `Accept: application/json`
  * **Success Response (200 OK):**
    ```json
    {
        "success": true,
        "status": 200,
        "message": "LiveKit token generated successfully",
        "data": {
            "user": {
                "user_id": 1,
                "name": "Test User",
                "email": "test@example.com",
                "livekit_token": "your_newly_generated_livekit_token",
                "room": "user_1"
            }
        },
        "errors": null
    }
    ```



    ** mac
# AI Teacher Project

This `README.md` file provides essential information and tips for setting up and managing the AI Teacher project.

## Database Setup

To create the database, use the following command in your MySQL client:

```sql
CREATE DATABASE ai_teacher;
MySQL Access:

Bash

mysql -u root -p
When prompted, enter your database password. Example: DB_PASSWORD=mir0188_2024

Common MySQL Commands:

SHOW DATABASES;

USE hrm_api;

SHOW TABLES;

DELETE FROM chat_messages;

DROP TABLE prospect_log_activities;

DESCRIBE project_phases;

CPanel Deployment Tips
When deploying to cPanel, keep the following in mind to avoid live issues:

New Document Root: Ensure your document root is correctly configured to point to the public folder of your Laravel application. For example: apidropship.biswasandbrothers.com/public.

Default Folders: cgi-bin and .well-known are default cPanel folders.

Image Display Issues: If images are not showing on the live site, run the following Artisan command to create a symbolic link from the storage folder to the public folder:

Bash

php artisan storage:link
API Setup for New Projects
When setting up a new project for an API, remember to add the API route in bootstrap/app.php:

PHP

// In bootstrap/app.php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Add this line
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // ...
API Token
Use the following token for API authentication:

-prefix_67e12b036e3f06.63889147




php artisan make:model Topic -mc


php artisan make:migration MainCategories


php artisan route:list

php artisan route:clear

php artisan make:controller LivekitTokenController --resource

php artisan make:model FacebookLeads -m

php artisan migrate:status


php artisan migrate:reset


php artisan migrate:fresh --seed


php artisan migrate:rollback
php artisan migrate
Database Column Modifications
Change Column Type:

SQL

ALTER TABLE tasks MODIFY COLUMN total_duration INT; -- Examples: INT, VARCHAR(255), DOUBLE
Add Timestamp Column (Example):

SQL

ALTER TABLE prospects ADD COLUMN last_activity TIMESTAMP NULL DEFAULT NULL;
Add New Column:

SQL

ALTER TABLE users ADD start_min INT NULL;
Remove a Column:

SQL

ALTER TABLE donation_project_models DROP COLUMN project_id;
Contact Numbers
01980911466

01810102520

Pabbly Workflow for Facebook Leads
To set up a Pabbly workflow for Facebook leads:

Facebook Lead Ads: Configure the trigger for Facebook Lead Ads.

MySQL: Connect to your MySQL database.

Get the hostname from WHM (top bar of the dashboard).

Ensure remote access database permissions are granted for the third-party port from cPanel.

Create Database: Create a dedicated database for facebook_leads.

Inserting Multiple Rows into MySQL (phpMyAdmin)
To insert a list of rows into a MySQL database via phpMyAdmin:

Select your database.

Go to the SQL tab.

Paste an INSERT statement similar to this example:

SQL

INSERT INTO industry_types (industry_type_name, is_active, created_at, updated_at) VALUES
('Warehouse', true, NOW(), NOW()),
('Retail', true, NOW(), NOW()),
('Manufacturing', true, NOW(), NOW());
Hostinger Commands
List directory contents: ls -la