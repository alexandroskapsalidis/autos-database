<!-- The initial page of the project  -->

<!----------------- The Model ------------------------>
<?php

// Including database connection code 
require_once "pdo.php";


// Handling login credentials
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST["email"]) && isset($_POST["password"])) {
    unset($_SESSION["email"]);  // Logout current user

    // Checking if they're empty
    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
      $_SESSION['error'] = "Email and password are required";
      header("Location: login.php");
      return;
    }

    // Checking @ character in the email
    if (strpos($_POST['email'], '@') === false) {
      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;
    }

    // Checking hashed password
    $salt = 'XyZzy12*_';
    $email = htmlentities($_POST['email']);
    $check = hash('md5', $salt . $_POST['password']);

    $stmt = $pdo->prepare("SELECT name, hashed_password FROM users WHERE email = :em");
    $stmt->execute(array(':em' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // var_dump($check);
    // echo '</pre>';
    // die();

    if ($row !== false) {

      $stored_hash = $row['hashed_password'];

      if ($check === $stored_hash) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];

        $_SESSION["success"] = "Logged in";
        header('Location: view.php');
        return;
      } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
      }
    } else {
      $_SESSION['error'] = "Incorrect password";
      header("Location: login.php");
      return;
    }
  }
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

    // Flash error message
    if (isset($_SESSION["error"])) {
      echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
      unset($_SESSION["error"]);
    }

    ?>


  </main>

</body>

</html>