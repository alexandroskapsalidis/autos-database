<!-- The main page of the project -->

<!----------------- The Model ------------------------>
<?php
session_start();
// Including database connection code 
require_once "pdo.php";

// A welcome message if we are loged in
if (isset($_SESSION['name'])) {
  echo ("<p style='padding: 10px; text-align:right;'>");
  echo (" Welcome " . $_SESSION['name'] . "!");
  echo ("</p>");
}

// Handling the Delete button
if (isset($_POST['delete']) && isset($_POST['auto_id'])) {
  $_SESSION["deleteMessage"] = "";
  $sql = "DELETE FROM autos WHERE auto_id = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['auto_id']));
  $_SESSION["deleteMessage"] = "The row deleted succesfully.";
  header("Location: app.php");
  return;
}

// Handling Insert new Auto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (
    isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])
  ) {

    // Checking if they're empty
    if (strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
      $_SESSION['error'] = "All the fields are required";
      header("Location: app.php");
      return;
    }
    $_SESSION["addMessage"] = "";
    $sql = "INSERT INTO autos (make, year, mileage)
            VALUES (:make, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':make' => $_POST['make'],
      ':year' => $_POST['year'],
      ':mileage' => $_POST['mileage']
    ));
    $_SESSION["addMessage"] = "The row inserted succesfully.";

    unset($_POST['make']);
    unset($_POST['year']);
    unset($_POST['mileage']);
    header("Location: app.php");
    return;
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
  <title>Autos Database</title>

  <style>
    h2 {
      font-size: 1.8rem;
    }
  </style>

</head>

<body>

  <main class="w-50 container bg-light my-5 p-5">
    <h1 class="mb-5 text-center">Autos Database</h1>
    <?php
    // No entrance if not logged in 
    if (! isset($_SESSION["email"])) {
      die('Not logged in');
    }
    ?>

    <!-- Showing all Autos -->
    <table class="table mt-4 p-5">
      <?php
      echo "<h2>All Autos</h2>";
      echo "<tr><th>Make</th><th>Year</th><th>Mileage</th><th>Edit</th>";
      foreach ($rows as $row) {
        echo "<tr><td>";
        echo htmlentities($row['make']);
        echo ("</td><td>");
        echo htmlentities($row['year']);
        echo ("</td><td>");
        echo htmlentities($row['mileage']);
        echo ("</td><td>");
        // We use a little form in every row with a Primary Key embeded in the hidden field 
        echo ('<form method="post"><input type="hidden" ');
        echo ('name="auto_id" value="' . htmlentities($row['auto_id']) . '">' . "\n");
        echo ('<input type="submit"  class="btn btn-danger px-4" value="Del" name="delete">');
        echo ("\n</form>\n");
        echo ("</td></tr>\n");
      }
      ?>
    </table>
    <?php
    // Message for succesfull deletion 
    if (!empty($_SESSION["deleteMessage"])) {
      echo '<p id="deleteMessage" style="color: green;">' . $_SESSION["deleteMessage"] . '</p>';
      unset($_SESSION["deleteMessage"]);
    }
    // Message for succesfull insertion 
    if (!empty($_SESSION["addMessage"])) {
      echo '<p id="addMessage" style="color: green;">' . $_SESSION["addMessage"] . '</p>';
      unset($_SESSION["addMessage"]);
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
    <?php

    // Flash error message for insertiion
    if (isset($_SESSION["error"])) {
      echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
      unset($_SESSION["error"]);
    }
    ?>
  </main>

  <script>
    // Hiding the message after some seconds 
    setTimeout(function() {
      let deleteMessage = document.getElementById('deleteMessage');
      let addMessage = document.getElementById('addMessage');
      if (deleteMessage) {
        deleteMessage.style.visibility = 'hidden';
      }
      if (addMessage) {
        addMessage.style.visibility = 'hidden';
      }
    }, 5000);
  </script>

</body>

</html>