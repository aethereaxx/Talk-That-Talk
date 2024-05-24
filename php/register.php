<?php
session_start();

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  $nama = $_POST["nama"];
  $tanggal_lahir = $_POST["tanggal_lahir"];

  try {
    $conn = new mysqli("localhost", "kelompok1sic", "pemwebsic", "data_user");
    $conn->set_charset("utf8");

    // Cek apakah username sudah digunakan
    $query_check_username = "SELECT COUNT(*) AS count FROM AKUN WHERE user = '$username'";
    $result_username = $conn->query($query_check_username);
    $row_username = $result_username->fetch_assoc();
    
    // Cek apakah email sudah digunakan
    $query_check_email = "SELECT COUNT(*) AS count FROM AKUN WHERE email = '$email'";
    $result_email = $conn->query($query_check_email);
    $row_email = $result_email->fetch_assoc();

    if ($row_username['count'] > 0) {
        $error_message = "Username is already used";
    } elseif ($row_email['count'] > 0) {
        $error_message = "This email is already used";
    } else {
        $query_insert = "INSERT INTO AKUN (user, password, email, nama, tanggal_lahir) VALUES ('$username', '$password', '$email', '$nama', '$tanggal_lahir')";
        if ($conn->query($query_insert) === TRUE) {
            $success_message = "Registration Succeeded";
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Registration failed: " . $conn->error;
        }
    }
} catch (mysqli_sql_exception $e) {
    $error_message = "Registration failed: " . $e->getMessage();
} finally {
    $conn->close();
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="..\Style\register.css">
</head>

<body>
  <div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form"
      onsubmit="return handleSubmit()">
      <h2>Register</h2>

      <?php if (!empty($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
      <?php endif; ?>
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="nama">Name</label>
        <input type="text" id="nama" name="nama" required>
      </div>
      <div class="input-group">
        <label for="tanggal_lahir">Birth Date</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
      </div>
      <button type="submit" class="login-button">Register</button>
    </form>
    <br>
    <p> Already have an account? <a href="login.php">Log in here.</a></p>
  </div>
  <script src="..\Js\Register.js"></script>
</body>

</html>
