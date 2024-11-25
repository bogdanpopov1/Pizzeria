<?
$USER;

if (!empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $database->prepare($sql);
    $stmt->bindValue(':id', $user_id);
    $stmt->execute();
    $res = $stmt->fetch();

    $USER = $res;
}
?>