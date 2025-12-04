<!-- The main page of the project -->

<!----------------- The Model ------------------------>
<?php
session_start();
// Including database connection code 
require_once "pdo.php";

// Handling the Delete button
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['delete']) && isset($_POST['auto_id'])) {
    $_SESSION["deleteMessage"] = "";
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
    $_SESSION["deleteMessage"] = "The row deleted succesfully.";
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
      die('<p style="color:red;font-size:1.3em;">Not logged in</p>');
    }
    ?>
    <h1 class="mb-5 text-center">Autos Database</h1>


    <!-- Showing all Autos -->
    <table class="table mt-4 p-5">
      <?php
      // Message for succesfull deletion 
      if (!empty($_SESSION["deleteMessage"])) {
        echo '<p id="deleteMessage" style="color: green; text-align:center; margin:0; padding:0;">' . $_SESSION["deleteMessage"] . '</p>';
        unset($_SESSION["deleteMessage"]);
      }
      // Message for succesfull insertion 
      if (!empty($_SESSION["addMessage"])) {
        echo '<p id="addMessage" style="color: green; text-align:center">' . $_SESSION["addMessage"] . '</p>';
        unset($_SESSION["addMessage"]);
      }
      echo "<h2>All Autos</h2>";
      echo "<tr><th>Make</th><th>Year</th><th>Mileage</th><th>Action</th>";
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
        echo ('<a class="btn btn-warning px-2 py-1 me-2" href="update.php?auto_id=' . $row['auto_id'] . '">Edit</a>');
        echo ('<input type="submit" class="btn btn-danger px-2  py-1" value="Delete" name="delete">');
        echo ("\n</form>\n");
        echo ("</td></tr>\n");
      }
      ?>
    </table>

    <p class="d-flex justify-content-left pt-4">
      <a href="add.php" class="btn btn-success  px-4 py-2">Add New Auto</a>
      <a href="index.php" class="btn btn-primary mx-4 px-4 py-2">Home</a>
      <a href="logout.php" class="btn btn-danger px-3 py-2">Log Out</a>
    </p>

    <?php
    // Flash error message for updating
    if (isset($_SESSION["error"])) {
      echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
      unset($_SESSION["error"]);
    }
    ?>


  </main>

  <script>
    // Hiding the messages after some seconds 
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

    // Confirm Deletion 
    document.querySelectorAll('input[name="delete"]').forEach(btn => {
      btn.addEventListener('click', function(event) {
        const ok = confirm("Are you sure you want to delete this auto?");
        if (!ok) {
          event.preventDefault(); // Stops the submit of the form
        }
      });
    });
  </script>

</body>

</html>
