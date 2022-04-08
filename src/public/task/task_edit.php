<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=todo; charset=utf8mb4", $dbUserName, $dbPassword);

$id = filter_input(INPUT_POST, 'id');
$contents = filter_input(INPUT_POST, "contents");
$deadline = filter_input(INPUT_POST, "deadline");
$category_id = filter_input(INPUT_POST, "category_id");

$sql = "UPDATE tasks SET contents=:contents, category_id=:category_id, deadline=:deadline  WHERE id = :id";

$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id);
$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
$statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement->bindParam(':deadline', $deadline, PDO::PARAM_STR);
$statement->execute();

header('Location: ../index.php');
exit;
