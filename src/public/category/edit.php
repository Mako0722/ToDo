<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

$id = filter_input(INPUT_POST, 'id');
$name = filter_input(INPUT_POST, 'name');

$sql = 'UPDATE categories SET name=:name WHERE id = :id';

$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->execute();

header('Location: ./index.php');
exit();
