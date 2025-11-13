<!-- In this file we only put the database connection code and then we require
 this file to the other files. We also set error mode. This helps us to see what
 is the reason when it blows up. Otherwise we see a blank screen and wonder what
 did we do wrong -->

<?php
$pdo = new PDO(
   'mysql:host=localhost;port=3306;dbname=misc',
   'fred',
   'zap'
);

// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
