<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "DELETE FROM tasks where id = $id";
$statement = $pdo->prepare($sql);
$statement->execute();

header('Location: ./index.php');
exit();
