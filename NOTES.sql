/* To get started run the following SQL commands.  */

CREATE DATABASE misc;

-- (Optional)
-- Create a MySQL user manually with full access to this database.
-- Example:
-- CREATE USER 'youruser'@'localhost' IDENTIFIED BY 'yourpassword';
-- GRANT ALL PRIVILEGES ON misc.* TO 'youruser'@'localhost';

USE misc; -- Or select misc in phpMyAdmin

-- Create the table users and populate with some data
CREATE TABLE users (
   user_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(128),
   email VARCHAR(128),
   hashed_password VARCHAR(128),
   INDEX(email)
) ENGINE=InnoDB CHARSET=utf8;

/*
Password hashing in this application uses a fixed salt value:
    $salt = 'XyZzy12*_';
The stored password hash is generated using:
    md5($salt . $password)
Example: To generate a hash for the password "456" in PHP:
    echo hash('md5', 'XyZzy12*_' . '456');
This will produce the value: e7cf3ef4f17c3999a94f2c6f612e8a888

 Example users to test login: 
 1) Email: alex@email.com
    Password: 123
    Stored hash = md5("XyZzy12*_" . "123") → 1a52e17fa899cf40fb04cfc42e6352f1    
 2) Email: alexia@email.com
    Password: 456
    Stored hash = md5("XyZzy12*_" . "456") → e7cf3ef4f17c3999a94f2c6f612e8a88
*/

INSERT INTO users (name, email, hashed_password)
VALUES ('Alex', 'alex@email.com', '1a52e17fa899cf40fb04cfc42e6352f1');

INSERT INTO users (name, email, hashed_password)
VALUES ('Alexia', 'alexia@email.com', 'e7cf3ef4f17c3999a94f2c6f612e8a88');

-- Create the table autos and populate with some data
CREATE TABLE autos (
   auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
   make VARCHAR(128),
   year INT,
   mileage INT,
   PRIMARY KEY(auto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

