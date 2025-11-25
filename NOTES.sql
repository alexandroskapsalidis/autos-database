/* To get started run the following SQL commands.
Create a user in the database with username: "alex" and password: "zap",
grant him with all permissions and give him access only through the localhost. */

CREATE DATABASE misc;
CREATE USER 'alex'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'alex'@'localhost';
CREATE USER 'alex'@'127.0.0.1' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'alex'@'127.0.0.1';

USE misc; (Or select misc in phpMyAdmin)

-- Creating the table users and populate with some data
CREATE TABLE users (
   user_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(128),
   email VARCHAR(128),
   password VARCHAR(128),
   INDEX(email)
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO users (name,email,password) VALUES ('Alex','alex@email.com','123');
INSERT INTO users (name,email,password) VALUES ('Alexia','alexia@email.com','456');

-- Creating the table autos and populate with some data
CREATE TABLE autos (
   auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
   make VARCHAR(128),
   `year` INTEGER,
   mileage INTEGER,
   PRIMARY KEY(auto_id)
);
