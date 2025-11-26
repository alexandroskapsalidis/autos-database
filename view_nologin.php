<!------------------ The View ------------------------>
<?php
session_start();
require_once "pdo.php";

// A welcome message if we are loged in
if (isset($_SESSION['name'])) {
  echo ("<p style='padding: 10px; text-align:right;'>");
  echo (" Welcome " . $_SESSION['name'] . "!");
  echo ("</p>");
}

?>

<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Autos Database</title>
</head>

<body>
  <div class="row">
    <main class="w-50 container bg-light my-5 p-5">
      <h1 class="mb-5 text-center">Autos Database</h1>

      <table class="table mt-4 mb-5 p-5">
        <?php

        // Fetching the autos to show them on a Table 
        $stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos ORDER BY make");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2 class='text-center'>All Autos</h2>";
        echo "<tr><th>Make</th><th>Year</th><th>Mileage</th>";
        foreach ($rows as $row) {
          echo "<tr><td>";
          echo ($row['make']);
          echo ("</td><td>");
          echo ($row['year']);
          echo ("</td><td>");
          echo ($row['mileage']);
          echo ("</td></tr>\n");
          echo ("\n</form>\n");
        }
        ?>
      </table>

      <p class="d-flex justify-content-center my-4">
        <a href="login.php" class="btn btn-success">Log In</a>
      </p>
    </main>
  </div>

</body>

</html>