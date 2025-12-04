<!-- Updating a row -->

<!----------------- The Model ------------------------>
<?php
session_start();
// Including database connection code 
require_once "pdo.php";

// Procesing UPDATE an existing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (
    isset($_POST['update'], $_POST['make'], $_POST['year'], $_POST['mileage'], $_POST['auto_id'])
  ) {

    // Checking if they're empty
    if (
      strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1
      || strlen($_POST['auto_id']) < 1
    ) {
      $_SESSION['error'] = "All the fields are required";
      header("Location: update.php?auto_id=" . $_POST['auto_id']);
      return;
    }
    // Validating Year 
    $year = $_POST['year'];
    if (!is_numeric($year) || $year < 1900 || $year > date("Y")) {
      $_SESSION['error'] = "Wrong year";
      header("Location: update.php?auto_id=" . $_POST['auto_id']);
      return;
    }
    // Validating Mileage 
    $mileage = $_POST['mileage'];
    if (!is_numeric($mileage) || $mileage < 0) {
      $_SESSION['error'] = "Wrong mileage";
      header("Location: update.php?auto_id=" . $_POST['auto_id']);
      return;
    }


    $_SESSION["addMessage"] = "";

    $sql = "UPDATE autos SET make = :make,
            year = :year, mileage = :mileage
            WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':make' => $_POST['make'],
      ':year' => $_POST['year'],
      ':mileage' => $_POST['mileage'],
      ':auto_id' => $_POST['auto_id']
    ));

    $_SESSION["addMessage"] = "The row updated succesfully.";

    unset($_POST['make']);
    unset($_POST['year']);
    unset($_POST['mileage']);
    header("Location: app.php");
    return;
  }
}

// Fetching the specific Auto
$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
  $_SESSION['error'] = 'Bad value for auto_id';
  header('Location: app.php');
  return;
}

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
  <link rel="icon" type="image/x-icon" href="car-favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Autos Database</title>

  <style>
    h2 {
      font-size: 1.4rem;
    }
  </style>

</head>

<body>
  <?php
  // A welcome message if we are loged in
  if (isset($_SESSION['name'])) {
    echo ("<p style='padding: 10px; text-align:right;'>");
    echo (" Hello <span style='color:blue; font-size: 1.2em;'>" . $_SESSION['name'] . "</span>");
    echo ("</p>");
  }
  ?>
  <main class="w-50 container bg-light my-5 p-5">

    <?php
    // No entrance if not logged in 
    if (! isset($_SESSION["email"])) {
      die('<p style="color:red; font-size:1.3em;">Not logged in</p>');
    }
    ?>

    <h1 class="mb-5 text-center">Autos Database</h1>

    <!-- Add New Auto form -->
    <!-- <br> -->
    <h2 class="pt-4">Update Auto</h2>
    <form method="post" class="mt-4">
      <p>Make:
        <input type="text" class="form-control" name="make" size="40" value="<?= htmlentities($row['make']) ?>">
      </p>
      <p>Year:
        <input type="number" class="form-control" name="year" min="1900" max="2099" step="1" value="<?= htmlentities($row['year']) ?>">
      </p>
      <p>Mileage:
        <input type="number" class="form-control" name="mileage" value="<?= htmlentities($row['mileage']) ?>">
      </p>
      <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
      <p>
        <input type="submit" class="btn btn-success" value="Update" name="update" />
        <a href="app.php" class="btn btn-warning mx-3 px-4">Cancel</a>
        <a href="logout.php" class="btn btn-danger px-3">Log Out</a>
      </p>
    </form>
    <?php

    // Flash error message for updating
    if (isset($_SESSION["error"])) {
      echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
      unset($_SESSION["error"]);
    }
    ?>
  </main>

  <script>

  </script>

</body>

</html>
