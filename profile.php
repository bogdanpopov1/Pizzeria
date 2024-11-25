<?php
session_start();
include 'connection/database.php';
if(empty($_SESSION['user_id'])) {
    header('Location: ./login.php');
}
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $database->prepare($sql);
$stmt->bindValue(':id', $user_id);
$stmt->execute();
$result = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include("header.php"); ?>
    <main class="profile-container">
        <div class="profile-card">
            <h1 class="profile-name"><?= $result["name"] ?></h1>
            <p class="profile-email">Email: <?= $result["email"]?></p>
        </div>
    </main>
    <?php include("footer.php"); ?>
</body>
</html>