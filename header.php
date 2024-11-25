<?php include("getUser.php"); ?>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <?php if (!empty($USER)): ?>
                <li><a href="profile.php">Профиль</a></li>
                <li><a href="logout.php">Выйти</a></li>
                <?php if ($USER['role'] === 'admin'): ?>
                    <li><a href="add.php">Добавить продукт</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="login.php">Войти</a></li>
                <li><a href="register.php">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>