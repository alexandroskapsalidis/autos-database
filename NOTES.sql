/* To get started run the following SQL commands. We create 
a user in the database with username: "fred" and password: "zap",
we grant him with all permissions and give him access only
through the localhost.The 'fred'@'localhost' is a trick to
firewall your database server from connections coming from
outside. */

CREATE DATABASE misc;
CREATE USER 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'fred'@'localhost';
CREATE USER 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'fred'@'127.0.0.1';

USE misc; (Or select misc in phpMyAdmin)


