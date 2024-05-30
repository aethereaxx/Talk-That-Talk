<?php
session_start();

if (isset($_SESSION["username"])) {
  if (substr($_SESSION["username"], 0, 5) === "t3adm") {
    header("Location: dashboard.php");
  } else {
    header("Location: timeline.php");
  }
  exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input = $_POST["input"]; 
  $password = $_POST["password"];

  $conn = mysqli_connect("localhost", "kelompok1sic", "pemwebsic", "data_user");

  if (substr($input, 0, 5) === "t3adm") {
    $query_admin = "SELECT * FROM admin WHERE username='$input' AND password='$password'";
    $result_admin = mysqli_query($conn, $query_admin);
    
    if (mysqli_num_rows($result_admin) == 1) {
      $_SESSION["username"] = $input; 
      header("Location: dashboard.php");
      exit();
    } else {
      $error_message = "Invalid admin credentials";
    }
  } else {

    $query_akun = "SELECT * FROM AKUN WHERE (user='$input' OR email='$input') AND password='$password'";
    $result_akun = mysqli_query($conn, $query_akun);

    if (mysqli_num_rows($result_akun) == 1) {
      $row_akun = mysqli_fetch_assoc($result_akun);
      $_SESSION["username"] = $row_akun["user"];
      header("Location: timeline.php");
      exit();
    } else {
      $error_message = "Username or Email or Password incorrect";
    }
  }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="..\Style\Login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Log In</title>
</head>
<body>
  <div class="container">
    <h1><img src="/Kelompok pemweb/img/Logo.png" alt="logo" width="90"></h1>
    <p>Please log in before you continue</p>
    <br>
    <?php if (!empty($error_message)) : ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
      <input type="text" id="input" name="input" placeholder="Username or Email">
      <input type="password" id="password" name="password" placeholder="Password">
      <button type="submit">Login</button>
    </form>
    <br>
    <p> Don't have account yet? <a href="register.php">Register now.</a></p>
  </div>
  <script src="..\Js\login_page.js"></script>
</body>
</html>
