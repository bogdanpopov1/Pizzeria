<?php
include 'connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim(htmlspecialchars($_POST['title']));
    $about = trim(htmlspecialchars($_POST['about']));
    $price = trim(htmlspecialchars($_POST['price']));

    if (empty($title) || empty($about) || empty($price)) {
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

    $sql = "INSERT INTO products (image, title, about, price) VALUES (:image, :title, :about, :price)";
    $stmt = $database->prepare($sql);
    $stmt->bindValue(":image", $fileName);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":about", $about);
    $stmt->bindValue(":price", $price);

    if ($stmt->execute()) {
        echo "<script>window.location.href = './index.php'</script>";
    } else {
        echo 'Ошибка запроса';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta title="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить пиццу</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Добавить новую пиццу</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="image">Фото:</label>
            <input type="file" id="image" name="image">
            <label for="title">Название пиццы:</label>
            <input type="text" id="title" name="title">
            <label for="about">Описание:</label>
            <textarea id="about" name="about"></textarea>
            <label for="price">Цена:</label>
            <input type="number" id="price" name="price">
            <button type="submit">Добавить</button>
        </form>
    </main>
    <?php include("footer.php") ?>
</body>

</html>