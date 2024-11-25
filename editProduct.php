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
    $id = trim(htmlspecialchars($_POST['id']));
    $title = trim(htmlspecialchars($_POST['title']));
    $description = trim(htmlspecialchars($_POST['about']));
    $price = trim(htmlspecialchars($_POST['price']));

    if (empty($title) || empty($description) || empty($price)) {
        echo 'Заполните все поля';
        return;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;

        $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo "<p>Файл успешно загружен: <a href='$uploadFile'>$fileName</a></p>";
            } else {
                echo "<p>Ошибка при загрузке файла.</p>";
            }
        } else {
            echo "<p>Недопустимый формат файла. Разрешены: JPG, JPEG, PNG, GIF.</p>";
        }
    }

    $sql = "UPDATE products SET image = :image, title = :title, about = :about, price = :price WHERE id = :id";
    $stmt = $database->prepare($sql);
    $stmt->bindValue(":image", $fileName);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":about", $description);
    $stmt->bindValue(":price", $price);
    $stmt->bindValue(":id", $id);

    if ($stmt->execute()) {
        echo "<script>window.location.href = './index.php'</script>";
    } else {
        echo 'Ошибка запроса';
        return;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать пиццу</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Редактировать пиццу</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="image">Фото:</label>
            <input type="file" id="image" name="image">
            <input type="hidden" id="id" name="id" value="<?= $result["id"] ?>">
            <label for="title">Название пиццы:</label>
            <input type="text" id="title" name="title" value="<?= $result["title"] ?>">
            <label for="about">Описание:</label>
            <textarea id="about" name="about"><?= $result["about"] ?></textarea>
            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" value="<?= $result["price"] ?>">
            <button type="submit">Сохранить изменения</button>
        </form>
    </main>
    <?php include("footer.php") ?>
</body>

</html>