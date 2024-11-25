<?php
include 'connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $database->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
    }

    if (empty($id)) {
        die('Id продукта не обнаружено');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали товара</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include("header.php") ?>
    <main class="product-container">
        <div class="product-card">
        <img src="uploads/<?= $result["image"] ?>" alt="<?= $result["image"] ?>" class="product-image" /> 
            <h1 class="product-name"><?= $result["title"] ?></h1>
            <p class="product-description">
            <?= $result["about"] ?>
            </p>
            <h2 class="product-price"><b><?= $result["price"] ?></b></h2>
            <a href="editProduct.php?id=<?= $result["id"] ?>" class="btn btn-primary">Редактировать</a>
            <a href="deleteProduct.php?id=<?= $result["id"] ?>" class="btn btn-primary">Удалить</a>
        </div>
    </main>
    <?php include("footer.php") ?>
</body>
</html>