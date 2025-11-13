<!-- In this file we only put the database connection code and then we require
 this file to the other files. We also set error mode. -->

<?php
$pdo = new PDO(
   'mysql:host=localhost;port=3306;dbname=misc',
   'alex',
   'zap'
);

// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
