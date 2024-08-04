<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "admin_project";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_errno());
}
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $re_password = $_POST['re_password'];

  // Validate name
  if (empty($name)) {
      $errors[] = "Name is required.";
  } elseif (strlen($name) < 3) {
      $errors[] = "Name must be at least 3 characters long.";
  }

  // Validate email
  if (empty($email)) {
      $errors[] = "Email is required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format.";
  }

  // Validate passwords
  if (empty($password) || empty($re_password)) {
      $errors[] = "Password and Re-enter Password fields are required.";
  } elseif ($password !== $re_password) {
      $errors[] = "Passwords do not match.";
  } elseif (strlen($password) < 6) {
      $errors[] = "Password must be at least 6 characters long.";
  }

  // Check if email already exists
  $stmt = $conn->prepare("SELECT * FROM admin_reg WHERE email = ?");
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
      $errors[] = "Email is already registered.";
  }
  $stmt->close();

  // If no errors, proceed with user registration
  if (empty($errors)) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $sql = "INSERT INTO admin_reg (name, email, password) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      if (!$stmt) {
          die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param("sss", $name, $email, $hashed_password);

      if ($stmt->execute()) {
          header("Location: log.php");
          exit();
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
  } else {
      // Display errors
      foreach ($errors as $error) {
          echo "<p style='color:red;'>$error</p>";
      }
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="re_password" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="log.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
