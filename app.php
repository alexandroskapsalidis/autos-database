<!-- The main page of the project -->


<!----------------- The Model ------------------------>
<?php

// Including database connection code 
require_once "pdo.php";

// Fetching the autos to show them on a Table 
$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos ORDER BY make");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!------------------ The View ------------------------>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Alexandros">
  <meta name="description" content="Car management project built with PHP and MySQL.">
  <meta name="keywords" content="PHP, MySQL, cars, management, project">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="rese.css" />
  <title>Autos Project</title>

  <style>

  </style>

</head>

<body>

  <main class="w-50 container bg-light my-5 p-5">
    <h1 class="mb-5 text-center">Welcome to Autos</h1>
    <table class="table mt-4 p-5">
      <?php
      echo "<h2>All Autos</h2>";
      echo "<tr><th>Make</th><th>Year</th><th>Mileage</th><th>Edit</th>";
      foreach ($rows as $row) {
        echo "<tr><td>";
        echo ($row['make']);
        echo ("</td><td>");
        echo ($row['year']);
        echo ("</td><td>");
        echo ($row['mileage']);
        echo ("</td><td>");
        // We create a little form in every row. There is a Primary Key embeded in the 
        // hidden field in each of those forms 
        echo ('<form method="post"><input type="hidden" ');
        echo ('name="auto_id" value="' . $row['auto_id'] . '">' . "\n");
        echo ('<input type="submit"  class="btn btn-danger px-4" value="Del" name="delete">');
        echo ("\n</form>\n");
        echo ("</td></tr>\n");
      }
      ?>
    </table>
  </main>

</body>

</html>