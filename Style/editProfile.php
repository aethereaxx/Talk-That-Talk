<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Database connection settings
$dsn = "mysql:host=localhost;dbname=data_user;charset=utf8mb4";
$dbUsername = "kelompok1sic";
$dbPassword = "pemwebsic";

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Fetch and sanitize input data
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $birth_date = $_POST['birth_date'];
        $password = $_POST['password'];

        // Prepare SQL query to update user details
        $sql = "UPDATE akun SET email = :email, nama = :nama, tanggal_lahir = :tanggal_lahir WHERE user = :username";
        
        if (!empty($password)) {
            // Hash the new password if it is set
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE akun SET email = :email, nama = :nama, tanggal_lahir = :tanggal_lahir, password = :password WHERE user = :username";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':nama', $name, PDO::PARAM_STR);
        $stmt->bindParam(':tanggal_lahir', $birth_date, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        $stmt->execute();

        // Redirect to the profile page after successful update
        header("Location: profile.php");
        exit();
    }

    // SQL query to fetch user details
    $sql = "SELECT user, email, nama, password, tanggal_lahir FROM akun WHERE user = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        die("No user found with the username: " . htmlspecialchars($username));
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../Style/editProfile.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>
    <nav>
      <div>
        <a href="timeline.php"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Edit Profile</h1>
      </div>
    </nav>
    <div class="hero">
      <div class="hero_container">
        <div class="profile_picture_container">
          <div class="layer">
            <i class="fa-solid fa-pen"></i>
          </div>
          <img
            src="../img/profile_pic.png"
            alt="profile"
            class="profile_picture"
          />
        </div>
      </div>
      <div class="hero_layer">
        <i class="fa-solid fa-pen"></i>
      </div>
    </div>
    <main>
      <div class="container">
        <form action="editProfile.php" method="post">
          <div class="card_container">
            <div class="card">
              <h2>Email</h2>
              <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required />
            </div>
            <div class="card">
              <h2>Username</h2>
              <input type="text" name="username" value="<?php echo htmlspecialchars($userData['user']); ?>" required readonly />
            </div>
            <div class="card">
              <h2>Name</h2>
              <input type="text" name="name" value="<?php echo htmlspecialchars($userData['nama']); ?>" />
            </div>
            <div class="card">
              <h2>Birth Date</h2>
              <input type="date" name="birth_date" value="<?php echo htmlspecialchars($userData['tanggal_lahir']); ?>" />
            </div>
            <div class="card">
              <h2>Password</h2>
              <input type="password" name="password" placeholder="Enter new password" />
            </div>
          </div>
          <div class="btn_container">
            <button type="submit">Save</button>
          </div>
        </form>
      </div>
    </main>
  </body>
</html>
