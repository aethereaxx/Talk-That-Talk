<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title)) {
        die("title cannot be empty.");
    }
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

        // Insert the new post into the database
        $sql = "INSERT INTO posts (title, content, author, created_at) VALUES (:title, :content, :author, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':author', $username, PDO::PARAM_STR);
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