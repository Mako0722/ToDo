<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

session_start();
$user_id = $_SESSION['user_id'];

$sql = 'SELECT * FROM categories';

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
    <title>カテゴリー</title>
</head>
<header class="text-gray-600 body-font">
        <h3>カテゴリ一覧</h3>
        <a href="../index.php"class="mr-5 hover:text-gray-900">TODO一覧</a>
    <body>
        </div>
            <form action="create.php" method="post">
                <div class="form-group">
                    <labe>カテゴリー登録</labe><br>
                        <input type="text" id="name" name="name" class="form-control" placeholder="カテゴリー">
                </div>
                    <button type="submit" value="カテゴリー" class="btn-primary" name="button">登録</button>
            </form>
        </div>
        <table>
            <thead>
            </thead>
            <tbody id="todo-body">
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['name']; ?></td>
                    <th><a href="./edit_form.php?id=<?php echo $category[
                        'id'
                    ]; ?>">編集</a></th>
                    <th><a href="./deletion.php?id=<?php echo $category[
                        'id'
                    ]; ?>">削除</a></th>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
