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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = trim(htmlspecialchars($_POST['id']));

    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $database->prepare($sql);
    $stmt->bindValue(":id", $product_id);

    if ($stmt->execute()) {
        echo "<script>window.location.href = './index.php'</script>";
    } else {
        echo 'Запрос не выполнен';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удалить пиццу</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <main>
        <h1>Удалить пиццу</h1>
        <form method="post">
            <h3>Удалить пиццу <?= $result["title"] ?>?</h3>
            <input type="hidden" name="id" value="<?= $result['id']?>">
            <button type="submit">Удалить</button>
            <a href="product.php?id=<?= $result['id']?>">Назад</a>
        </form>
    </main>
    <?php include("footer.php") ?>
</body>
</html>