<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) && !isset($_COOKIE['user_login'])) {
    header("Location: index.html");
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : $_COOKIE['user_login'];
$stmt = $conn->prepare("SELECT last_login FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($lastLogin);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>Last login: <?php echo $lastLogin; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
