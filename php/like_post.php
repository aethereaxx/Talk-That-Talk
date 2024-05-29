<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $postID = $_POST['postID'];

    // Database connection settings
    $dsn = "mysql:host=localhost;dbname=data_user;charset=utf8mb4";
    $dbUsername = "kelompok1sic";
    $dbPassword = "pemwebsic";

    try {
        // Create a PDO instance (connect to the database)
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the user has already liked the post
        $sql = "SELECT * FROM likes WHERE postID = :postID AND user = :user";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':user', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // Insert a new like into the database
            $sql = "INSERT INTO likes (postID, user) VALUES (:postID, :user)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->bindParam(':user', $username, PDO::PARAM_STR);
            $stmt->execute();
        }

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