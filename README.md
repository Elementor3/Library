# Local Web Shop Project

## Overview

This project was developed as part of the educational program at **LPEM**.  
The goal of the project is to create a **local web shop** using **XAMPP** and the following technologies:

- PHP  
- CSS  
- JavaScript  
- MySQL (via phpMyAdmin)

The application implements a basic e-commerce workflow with user authentication, product management, and order processing.

---

## Features

### User Authentication
- User registration
- User login
- Two user roles:
  - **Regular user**
  - **Administrator**

### User Functionality
- View a grid/list of available products
- Add products to the shopping cart
- Place an order

### Administrator Functionality
- Access to an **admin panel**
- Create, edit, and delete users
- Create, edit, and delete products
- Approve or decline customer orders
- Automatically recalculate product stock after order approval

---

## Technologies Used

- **Backend:** PHP
- **Frontend:** HTML, CSS, JavaScript
- **Database:** MySQL
- **Local Server Environment:** XAMPP
- **Database Management:** phpMyAdmin

---

## Installation and Setup Instructions

Follow the steps below to run the project locally.

### 1. Install XAMPP
Download and install XAMPP from the official website:  
https://www.apachefriends.org/

Make sure the following services are available:
- Apache
- MySQL

---

### 2. Start Apache and MySQL
Open the XAMPP Control Panel and start:
- **Apache**
- **MySQL**

---

### 3. Copy Project Files
1. Navigate to your XAMPP installation directory.
2. Open the `htdocs` folder.
3. Copy the project folder (e.g. `web_shop`) into `htdocs`.

Example:
C:\xampp\htdocs\web_shop


---

### 4. Create the Database
1. Open your browser and go to:
2. Create a new database (for example: `your_database_name`).
3. Import the provided SQL file.
---

### 5. Configure Database Connection
Open the `db.php` file and set:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "you_database_name";
```
---

Open a browser and navigate to:
http://localhost/web_shop (or wherever you saved it)



