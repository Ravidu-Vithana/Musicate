# Musicate 🎶

**Musicate** is an e-commerce platform for purchasing music instruments. The platform is built with PHP and MySQL and provides distinct user roles for **Users** (customers) and **Admins** (site administrators).

## Features
- **User Role**: Browse instruments, view details, add to cart, and proceed with purchases.
- **Admin Role**: Manage products, view orders, update inventory, and manage users.

## Table of Contents
- [Setup Instructions](#setup-instructions)
- [Installation](#installation)
- [Usage](#usage)

---

## Setup Instructions

### Prerequisites
- **PHP** (>=7.4 recommended)
- **MySQL** server
- **Web Server** (e.g., Apache or Nginx)

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Ravidu-Vithana/Musicate.git
   cd Musicate
   
2. **Database Setup**:
    - **Import the provided sample database into your MySQL server**
       ```bash
       mysql -u yourUsername -p shop_db < sample_database.sql
       ```
    - **Update the database connection details in connection.php**
       ```bash
       mysql -u yourUsername -p shop_db < sample_database.sql

3. **Configure Web Server**:
    - **Point your web server's document root to the project directory.**
    - **Ensure PHP is enabled and correctly configured on the server.**

4. **Access the Application**:
    - **After installation, you can log in as an admin using sample credentials available in the sample data. Check the users table in your database for login details.**

### **Usage**:
- **For Users**: Explore available musical instruments, add them to the cart, and make purchases.
- **For Admins**: Use the Admin Dashboard to manage products, view order details, and handle user accounts
