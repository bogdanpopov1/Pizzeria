<?php
session_start();
include("connection/database.php");

$sql = "SELECT * FROM products";
$stmt = $database->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пиццерия</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Добро пожаловать в нашу пиццерию!</h1>
        <p>Вкуснейшая пицца по вашему вкусу. Заказывайте прямо сейчас!</p>

        <div class="products">

            <?php
            foreach ($result as $row):

                ?>
                <div class="product">
                    <img src="uploads/<?= $row["image"] ?>" alt="<?= $row["image"] ?>" class="product-image" />
                    <h3><?= $row["title"] ?></h3>
                    <p><?= $row["about"] ?></p>
                    <h3><?= $row["price"] ?></h3>
                    <a href='product.php?id=<?= $row['id'] ?>'>Подробнее</a>
                </div>
            <?php
            endforeach;
            ?>

        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>