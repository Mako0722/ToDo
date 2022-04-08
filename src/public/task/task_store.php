<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=todo; charset=utf8mb4", $dbUserName, $dbPassword);

session_start();
$user_id = $_SESSION['formInputs']['userId'];
$contents = filter_input(INPUT_POST, "contents");
$deadline = filter_input(INPUT_POST, "deadline");
$category_id = filter_input(INPUT_POST, "category");


$sql = "INSERT INTO `tasks`(`user_id`, `contents`,`category_id`,`deadline`) VALUES (:user_id, :contents, :category_id, :deadline)";

$statement = $pdo->prepare($sql);


$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
$statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement->bindParam(':deadline', $deadline, PDO::PARAM_STR);
$statement->execute();


// リダイレクト処理
header('Location: ../index.php');
// リダイレクトしても処理が一番下まで続いてしまうので「exit」しておこう！！！
exit;
?>
