<!-- The initial page of the project  -->

<!----------------- The Model ------------------------>
<?php
session_start();

// A welcome message if we are loged in
if (isset($_SESSION['name'])) {
  echo ("<p style='padding: 10px; text-align:right;'>");
  echo (" Welcome " . $_SESSION['name'] . "!");
  echo ("</p>");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="rese.css" />
  <title>Autos Database</title>

  <style>

  </style>

</head>

<body>

  <main class="w-60 container bg-light my-5 p-5">
    <h1 class="mb-5 text-center">Welcome to Autos Database</h1>
    <?php
    if (isset($_SESSION["success"])) {
      echo ('<p style="color:green" class="text-center">' . $_SESSION["success"] . "</p>\n");
      unset($_SESSION["success"]);
    }

    // Check if we are logged in!
    if (! isset($_SESSION["account"])) { ?>
      <p class="d-flex justify-content-center my-4">
        <a href="login.php" class="btn btn-success">Log In</a>
        <a href="view_nologin.php" class="btn btn-primary mx-3">View our Autos</a>
      </p>
    <?php } else { ?>
      <p class="text-center">This is where a cool application would be.</p>
      <p class=" d-flex justify-content-center my-4">
        <a href="view.php" class="btn btn-primary mx-3">View our Autos</a>
        <a href="logout.php" class="btn btn-danger">Log Out</a>
      </p>
    <?php } ?>
  </main>

</body>

</html>