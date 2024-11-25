<?php
include 'connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    if (empty($email) || empty($password)) {
        $errors[] = 'Заполните все поля';
    }

    if (empty($errors)) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $database->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            if (password_verify($password, $result['password'])) {
                session_start();
                $_SESSION['user_id'] = $result['id'];
                header('Location: ./profile.php');
                exit();
            } else {
                $errors[] = 'Пароль не верен';
            }
        } else {
            $errors[] = 'Пользователь не обнаружен';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include("header.php") ?>
    <main>
        <h1>Авторизация</h1>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Войти</button>
        </form>
    </main>
    <?php include("footer.php") ?>
</body>
</html>