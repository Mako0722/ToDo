<?php

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "UPDATE tasks SET status= 1 WHERE id = $id ";

// $sql = "WHERE FROM tasks where status = $status";

$statement = $pdo->prepare($sql);
$statement->execute();

header('Location: ../index.php');
exit();
