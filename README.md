# Rental Mobil App

A simple car rental application built with native PHP.

## Prerequisites

*   PHP version 7.1 or higher.
*   Composer dependency manager.

## Setup

To run this project, you need to set up the environment variables and install dependencies.

### Environment Variables

Create a file named `.env` in the root directory of the project. This file will store your database connection details. Add the following variables:

```env
DB_HOST=your_database_host
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASSWORD=your_database_password
```

Replace the placeholder values with your actual database credentials.

### Dependencies

This project uses Composer to manage PHP dependencies. The primary dependency used for handling environment variables is `vlucas/phpdotenv` (version ^5.6).

To install Composer, follow the official guide: [https://getcomposer.org/doc/00-intro.md](https://getcomposer.org/doc/00-intro.md)

Once Composer is installed, navigate to the project root in your terminal and run:

```bash
composer install
```

This command will read the `composer.lock` file and install all necessary libraries into the `vendor/` directory.

## Database Setup

This project requires a MySQL database. You need to import the provided SQL file (`rental_mobil.sql`) into your database.

Choose one of the methods below:

### Method 1: Using phpMyAdmin or Similar Tool

1.  Open your database management tool (e.g., phpMyAdmin, Adminer).
2.  Create a new database (make sure the name matches the `DB_NAME` in your `.env` file).
3.  Select the newly created database.
4.  Navigate to the "Import" tab.
5.  Choose the `rental_mobil.sql` file from your project directory.
6.  Click "Go" or "Import" to execute the SQL statements.

### Method 2: Using Database Command Line

Open your terminal or command prompt and execute the following command. Replace `your_database_user`, `your_database_name`, and `path/to/rental_mobil.sql` with your actual details.

```bash
mysql -u your_database_user -p your_database_name < path/to/rental_mobil.sql
```

You will be prompted to enter the database user's password.

## Running the Application

To run this application locally using XAMPP, follow these steps:

1.  **Install XAMPP:** If you don't have XAMPP installed, download and install it from the official Apache Friends website ([https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)).
2.  **Copy Project Files:** Copy the entire project folder (`ecom_ok`) into the `htdocs` directory of your XAMPP installation (e.g., `C:\xampp\htdocs\` on Windows, `/Applications/XAMPP/htdocs/` on macOS, or `/opt/lampp/htdocs/` on Linux).
3.  **Start Apache and MySQL:** Open the XAMPP Control Panel and start the Apache and MySQL modules.
4.  **Access the Application:** Open your web browser and navigate to `http://localhost/ecom_ok/`. If you copied the files into a different folder name inside `htdocs`, replace `ecom_ok` with that folder name.

Alternatively, you can configure a virtual host for a cleaner URL.

## Default Credentials

For testing and initial access, you can use the following default login credentials:

*   **Admin User:**
    *   Username: `admin`
    *   Password: `demo`

*   **Demo User:**
    *   Username: `demo`
    *   Password: `demo`

**Note:** It is highly recommended to change these default credentials immediately after setting up the application for security reasons. 