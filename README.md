# Expense Submission & Review System


A Laravel based internal tool for employees to submit expenses and for admins to review them.  
Includes user authentication, expense listing with filters, file uploads, and REST API.


# Features:

- Submit new expenses with file (receipt) attachment (JPEG, PNG, JPG, PDF, 2MB max)
- Each expense includes a category
- User login & registration via Laravel UI
- Filter expenses by status (pending, approved, rejected)
- Admin seeded by default, can view all expenses and create expense category
- RESTful API to list and create expenses


## Setup Instructions

1. Clone / Download the Repository

   https://github.com/reena-abraham/expense-submission-system.git

2. Install Dependencies

    composer install
    npm install && npm run dev

3. Environment Setup
  
   Copy the .env.example file and update DB credentials

   php artisan key:generate

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=expense-system
    DB_USERNAME=root
    DB_PASSWORD=

4. Run Migrations and Seeders

   php artisan migrate
   php arisan db:seed
       OR
   php artisan migrate --seed


   Default admin credentials:

    username : admin@gmail.com
    password : admin123

   Run the application using the below command:

        php artisan serve

        Visit http://localhost:8000 in your browser

    ####
    Admin and user share the same login page. Admin can login using seeded credentials(above).
    Users should register via the registration form.


API Endpoints
######
Method	   Endpoint	            Description
-----------------------------------------------------
POST	   /api/v1/login	     Login and receive an API token
GET	       /api/v1/expenses	     List all expenses for the authenticated user
POST	   /api/v1/expenses	     Submit a new expense
GET        /api/v1/categories    List all available expense categories

# postman collection

https://www.postman.com/reena-33478/workspace/expense-submission-api/collection/46395847-0473d1a2-7a07-41f9-a236-401048d9dc7b?action=share&creator=46395847

# demo video

path : demo_video/video
