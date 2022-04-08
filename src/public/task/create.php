<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=todo; charset=utf8mb4", $dbUserName, $dbPassword);


$sql = "SELECT * FROM categories";

$statement = $pdo->prepare($sql);
$statement->execute();

$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="row justify-content-center">
        <form action="task_store.php" method="post">
            <div class="form-group">
                <h2><label>タスクの追加</label></h2>
            </div>
            <div class="form-group">
                <input type="text" id="contents" name="contents" class="form-control"  placeholder="タスク">
            </div>
            <div class="form-group">
                <input type="date" id="deadline" name="deadline" class="form-control">
            </div>
            <select name='category'>
                <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <div class="form-group">
                <button type="submit" value="送信" class="btn-primary" name="button">送信</button>
            </div>
        </form>
    </div>
</body>
</html>
