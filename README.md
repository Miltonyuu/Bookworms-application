# Bookworms Application
Bookworms Connect demonstrably improves the customer shopping experience. By creating a centralized marketplace, users gain efficient access to a vast selection of books. Additionally, Bookworms Connect empowers book owners with increased operational efficiency and sales opportunities through features like user-friendly listing management and secure online transactions.

## Features
- The system allows both verified sellers and regular users to list their books for sale.
- The system allows sellers to indicate if a product is available for trading.
- The system allows buyers to track their order history in the "Orders" section.
- The system allows users to communicate in real-time using a chat feature.
- The system provides image upload and display functionality for product listings.
- The system enables sellers to add, edit, and delete their book listings.


## Installation

Download and install XAMPP for your operating system from the official Apache Friends website: https://www.apachefriends.org/
Ensure you have a code editor or IDE of your choice (e.g., Visual Studio Code, Sublime Text, Atom) installed for editing the application files.
Installation Steps:

XAMPP Installation:

- Run the downloaded XAMPP installer and follow the on-screen instructions.
During installation, choose the following components:
Apache HTTP Server
MySQL Database
PHP (ensure the version is compatible with your application's requirements)

- Optional: For development purposes, you might also consider installing phpMyAdmin, a web-based administration tool for MySQL.
Create a MySQL Database:

- Open the XAMPP Control Panel (usually accessible at http://localhost/xampp/ or http://127.0.0.1/xampp/).
Click on the "Start" buttons next to "Apache" and "MySQL" to start the services.
Using phpMyAdmin (optional):
If you installed phpMyAdmin, navigate to http://localhost/phpmyadmin/ in your web browser.
In the left-hand panel, click on "New" to create a new database.
Enter a name for your database (e.g., shop_db).
Select the character set (e.g., utf8mb4_unicode_ci) and click "Create" to create the database.
Import the database included in the in files (shop_db.sql)

Configure Application Database Connection:

- Locate the PHP file(s) in your Bookworms application that handle database connection (e.g., config.php, database.php).
Edit these files to provide the following credentials:
Database host (usually localhost)
Database name (the name you created in step 2, e.g., bookworms_db)
Database username (your MySQL username)
Database password (your MySQL password)
Copy Application Files to Document Root:

- Open your XAMPP installation directory (usually C:\xampp\htdocs on Windows or /Applications/XAMPP/htdocs on macOS).
Create a new directory for your Bookworms application (e.g., bookworms).
Copy all the application files (PHP, HTML, CSS, and other assets) from your Git repository into this newly created directory.
Verify Installation:

- Open a web browser and navigate to the URL of your application (e.g., http://localhost/bookworms/ if your application directory is named bookworms).
If the installation is successful, you should see your Bookworms application running in the browser.



## Accounts for Administrator
- username: minimoy@gmail.com
- password: 123

## Accounts for Users
- username: yoshiro@gmail.com
- password: 123
<br></br>
- username: jc@gmail.com
- password: 123
<br></br>
- username: katakana@gmail.com
- password: 123

- password: 123

## LINK:
- https://bookwormsconnect.tech/login.php


## Contributing
We welcome contributions! Please fork the repository and create a pull request with your changes. Ensure your code follows our coding guidelines and is well-documented.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
