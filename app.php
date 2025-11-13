<!-- The main page of the project -->


<!----------------- The Model ------------------------>
<?php

// Including database connection code 
require_once "pdo.php";

// Handling the Delete button
$deleteMessage = "";
if (isset($_POST['delete']) && isset($_POST['auto_id'])) {
  $sql = "DELETE FROM autos WHERE auto_id = :zip";
  // echo "<pre>\n$sql\n</pre>\n";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['auto_id']));
  $deleteMessage = "The row deleded succesfully.";
  $sqlDeleteQuery = $sql;
}

// Handling the Insert new Auto form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (
    isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])
  ) {
    $sql = "INSERT INTO autos (make, year, mileage)
            VALUES (:make, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':make' => $_POST['make'],
      ':year' => $_POST['year'],
      ':mileage' => $_POST['mileage']
    ));
  }
}

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
    h2 {
      font-size: 1.8rem;
    }
  </style>

</head>

<body>

  <main class="w-50 container bg-light my-5 p-5">
    <h1 class="mb-5 text-center">Welcome to Autos</h1>

    <!-- Showing all Autos -->
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
        // A little form in every row with a Primary Key embeded in the hidden field 
        echo ('<form method="post"><input type="hidden" ');
        echo ('name="auto_id" value="' . $row['auto_id'] . '">' . "\n");
        echo ('<input type="submit"  class="btn btn-danger px-4" value="Del" name="delete">');
        echo ("\n</form>\n");
        echo ("</td></tr>\n");
      }
      ?>
    </table>
    <?php
    // Message for succesfull deletion 
    if (!empty($deleteMessage)) {
      echo '<h5 class="deleteMessage text-success">' .  htmlentities($deleteMessage) . '</h5>';
    }
    ?>

    <!-- Add New Auto form -->
    <!-- <br> -->
    <h2 class="pt-4">Add New Auto</h2>
    <form method="post" class="mt-4">
      <p>Make:
        <input type="text" class="form-control" name="make" size="40">
      </p>
      <p>Year:
        <input type="number" class="form-control" name="year" min="1900" max="2099" step="1">
      </p>
      <p>Mileage:
        <input type="number" class="form-control" name="mileage">
      </p>
      <p><input type="submit" class="btn btn-success" value="Add New" /></p>
    </form>
  </main>


  <script>
    // Hiding the delete message after some seconds 
    setTimeout(function() {
      var msg = document.querySelector('.deleteMessage');
      if (msg) {
        msg.style.visibility = 'hidden';
      }
    }, 5000);
  </script>

</body>

</html>