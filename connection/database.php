<?php

$host = 'localhost';
$dbname = 'pizzeria';
$username = 'root';
$password = 'root';

try {
    $database = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $username, $password);
} catch (PDOException $error) {
    die('Ошибка подключения к базе данных: ' . $error->getMessage());
}