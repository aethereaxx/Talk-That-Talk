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

    $conn = new mysqli("localhost", "kelompok1sic", "pemwebsic", "data_user");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    mysqli_report(MYSQLI_REPORT_OFF);

    $stmt = $conn->prepare("INSERT INTO AKUN (user, password, nama, tanggal_lahir) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("ssss", $username, $password, $nama, $tanggal_lahir);

    if ($stmt->execute()) {
        $success_message = "Registration Succeed";
        header("Location: login.php");
        exit();
    } else {
        if ($stmt->errno == 1062) { 
            $error_message = "Username is unavailable";
        } else {
            $error_message = "Registration failed: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form" onsubmit="return handleSubmit()">
      <h2>Register</h2>

      <?php if (!empty($success_message)) : ?>
      <div class="success-message"><?php echo $success_message; ?></div>
      <?php endif; ?>

      <?php if (!empty($error_message)) : ?>
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
  </div>
  <script src="..\Js\Register.js"></script>
</body>
</html>
