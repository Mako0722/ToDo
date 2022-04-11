<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);
session_start();
$user_id = $_SESSION['formInputs']['userId'];
$name = filter_input(INPUT_POST, 'name');

$sql = 'INSERT INTO `categories`(`name`,`user_id`) VALUES (:name, :user_id)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$statement->execute();

header('Location: ./index.php');
exit();
?>
