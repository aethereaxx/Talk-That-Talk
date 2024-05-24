<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../Style/timeline.css">
  <title>Timeline</title>
</head>
<body>
  <header>
    <div class="logo">
      <img src="../img/Logo.png" alt="Logo" width="55">
    </div>
    <h1>Timeline</h1>
  </header>
  <div class="container">
    <aside class="menu">
      <nav>
        <ul>
          <li><a href="timeline.php">Timeline</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="mute.php">Mute and Blocked</a></li>
          <li><a href="information.php">Information</a></li>
          <li><a href="license.php">License</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </aside>
    <main class="main-container">
      <div class="kontennn">
        <div class="post-container">
          <h2>Post Content</h2>
          <textarea id="post-content" name="post-content" placeholder="Write your question here..." rows="8"></textarea>
          <button type="submit" class="post-button">Post</button>
        </div>
      </div>
      <div class="suggestion-container">
        <h2>Suggestion</h2>
        <!-- Dummy suggestions-->
      </div>
    </main>
  </div>
  <script src="js/Timeline.js"></script>
</body>
</html>
