<!-- The initial page of the project  -->

<!----------------- The Model ------------------------>
<?php

// Including database connection code 
require_once "pdo.php";

// Handling login credentials in simple way
if (isset($_POST['email']) && isset($_POST['password'])) {
  $sql = "SELECT name FROM users 
        WHERE email = :em AND password = :pw";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':em' => $_POST['email'],
    ':pw' => $_POST['password']
  ));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
  <title>Autos Project</title>

  <style>

  </style>

</head>

<body>

  <main class="w-50 container bg-light my-5 p-5">
    <h1 class="mb-5 text-center">Autos Database</h1>
    <p>Please Login</p>
    <form method="post">
      <p>Email:
        <input type="text" size="40" name="email" class="form-control">
      </p>
      <p>Password:
        <input type="text" size="40" name="password" class="form-control">
      </p>
      <p><input type="submit" value="Login" class="btn btn-success">
        <a href="<?php echo ($_SERVER['PHP_SELF']); ?>" class="btn btn-warning mx-3">Refresh</a>
      </p>
    </form>

    <?php
    if (isset($_POST['email']) && isset($_POST['password'])) {
      if ($row === FALSE) {
        echo "<h3 class='text-danger mt-4'>Login incorrect.</h3>\n";
      } else {
        echo "<h3 class='text-success mt-4'>Login success.</h3>\n";
        echo "<a href='app.php'>Proceed to the Application</a>";
      }
    }
    ?>
  </main>

</body>

</html>