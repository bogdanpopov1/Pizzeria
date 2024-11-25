<?php
include 'connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];

    $login = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $re_password = trim(htmlspecialchars($_POST['re_password']));

    if (empty($login) || empty($email) || empty($password) || empty($re_password)) {
        $errors[] = 'Заполните все поля!';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный формат email!';
    } else if (strlen($password) < 5) {
        $errors[] = 'Введи минимум 5 символов!';
    } else if ($password !== $re_password) {
        $errors[] = 'Пароли не совпадают!';
    }

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $database->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if ($result) {
        $errors[] = 'Email уже используется!';
    }

    if (empty($errors)) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
        $stmt = $database->prepare($sql);
        $stmt->bindValue(':name', $login);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hashPassword);

        if ($stmt->execute()) {
            header('Location: ./login.php');
        } else {
            $errors[] = 'Ошибка запроса';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Регистрация</h1>
        <form action="register.php" method="post">
            <label for="name">Имя пользователя:</label>
            <input type="text" id="name" name="name">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password">
            <label for="password">Подтверждение пароля:</label>
            <input type="password" name="re_password">
            <?php
            if (!empty($errors)):
                ?>
                <div style='color: red;'>
                    <? foreach ($errors as $error): ?>
                        <p> <?= $error ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>