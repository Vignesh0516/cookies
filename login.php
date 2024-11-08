<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;

        if ($rememberMe) {
            setcookie("user_login", $username, time() + (30 * 24 * 60 * 60), "/");
        }

        $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE username = ?");
        $updateStmt->bind_param("s", $username);
        $updateStmt->execute();
        $updateStmt->close();

        header("Location: profile.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
