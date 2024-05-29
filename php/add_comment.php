<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $postID = $_POST['postID'];
    $content = trim($_POST['content']);

    if (empty($content)) {
        die("Content cannot be empty.");
    }

    // Database connection settings
    $dsn = "mysql:host=localhost;dbname=data_user;charset=utf8mb4";
    $dbUsername = "kelompok1sic";
    $dbPassword = "pemwebsic";

    try {
        // Create a PDO instance (connect to the database)
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert the new comment into the database
        $sql = "INSERT INTO comments (postID, content, user, created_at) VALUES (:postID, :content, :user, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':user', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect back to the timeline page
        header("Location: timeline.php");
        exit();

    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    header("Location: timeline.php");
    exit();
}
?>
