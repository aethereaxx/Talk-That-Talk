<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postID = $_POST['postID'];
    $username = $_SESSION['username'];

    // Database connection settings
    $dsn = "mysql:host=localhost;dbname=data_user;charset=utf8mb4";
    $dbUsername = "kelompok1sic";
    $dbPassword = "pemwebsic";

    try {
        // Create a PDO instance (connect to the database)
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the post exists and is authored by the logged-in user
        $sql = "SELECT author FROM posts WHERE postID = :postID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            die("Post not found.");
        }

        if ($post['author'] !== $username) {
            die("You do not have permission to delete this post.");
        }

        // Delete the post
        $sql = "DELETE FROM posts WHERE postID = :postID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the profile page
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: " . $referrer);
        exit();

    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    header("Location: profile.php");
    exit();
}
?>