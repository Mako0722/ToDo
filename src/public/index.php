<?php

session_start();
require_once __DIR__ . './../app/Infrastructure/Redirect/redirect.php';

if (!isset($_SESSION['formInputs']['userId'])) {
    redirect('../user/signin.php');
}

if (isset($_SESSION['formInputs']['userId'])) {
    //ログインしているとき
    $link = '<a href="./user/logout.php">ログアウト</a>';
} else {
    //ログインしていない時
    $msg = 'ログインしていません';
    $link = '<a href="./login.php">ログイン</a>';
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);



//昇順降順
if (isset($_GET['order'])) {
    $direction = $_GET['order'];
} else {
    $direction = 'desc';
}
//検索
if (isset($_GET['search'])) {
    $contents = '%' . $_GET['search'] . '%';
} else {
    $contents = '%%';
}

if (isset($_GET['status']) and $_GET['status'] == 'completion') {
    $status = 'T.status = 1';
} elseif (isset($_GET['status']) and $_GET['status'] == 'uncompletion') {
    $status = 'T.status = 0';
} else {
    $status = 'T.status = 1 OR T.status = 0';
}

if (isset($_GET['category'])) {
    $category = 'AND T.category_id = ' . $_GET['category'];
} else {
    $category = '';
}



$sql = "SELECT T.id, T.user_id, T.status, T.contents, T.category_id, T.deadline, C.name AS category_name FROM tasks AS T INNER JOIN categories AS C ON T.category_id = C.id WHERE T.contents LIKE :contents AND $status $category ORDER BY id $direction";

$statement = $pdo->prepare($sql);
$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
$statement->execute();

$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM categories';
$statement = $pdo->prepare($sql);
$statement->execute();

$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($tasks as $kie => $task) {
    if ($task['status'] == '0') {
        $tasks[$kie]['status'] = '未完了';
    } else {
        $tasks[$kie]['status'] = '完了';
    }
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>tasks</title>
</head>
<header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <span class="ml-3 text-xl">TODOリスト</span>
    </a>
    <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
      <a href="task/create.php"class="mr-5 hover:text-gray-900">タスク追加</a>
      <a href="./category/index.php" class="mr-5 hover:text-gray-900">カテゴリ一覧</a>
      <a class="mr-5 hover:text-gray-900"><?php echo $link; ?></a>
    </nav>
  </div>
</header>
    <body>
      <div class="container">
        <form action="index.php" method="get">
          <div class="ml-8">
              <label>
                <input type="radio" name="status" value="completion" class="">
                <span>完了</span>
              </label>
              <label>
                <input type="radio" name="status" value="uncompletion" class="">
                <span>未完了</span>
              </label>
          </div>
            <select name='category'>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category[
                    'id'
                ]; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
          <!-- 検索 -->
          <div class="ml-8 mb-6">
            <input name="search" type="text" value="<?php echo $_GET[
                'search'
            ] ?? ''; ?>" placeholder="キーワードを入力" />
            <input type="submit" value="検索" />
          </div>
          <div class="ml-8">
            <label>
              <!-- 新着順 -->
              <input type="radio" name="order" value="desc" class="">
              <span>新着順</span>
            </label>
            <label>
              <input type="radio" name="order" value="asc" class="">
              <span>古い順</span>
            </label>

          </div>
        </form>
      <table>
          <thead>
            <tr>
              <th>タスク</th>
              <th>締め切り</th>
              <th>カテゴリー</th>
            </tr>
          </thead>
        <tbody id="todo-body"></tbody>
          <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo $task['contents']; ?></td>
                <td><?php echo $task['deadline']; ?></td>
                <td><?php echo $task['category_name']; ?></td>

                <th><a href="/task/updateStatus.php?id=<?php echo $task[
                    'id'
                ]; ?>"><?php echo $task['status']; ?></a></th>
                <th><a href="/task/edit_form.php?id=<?php echo $task[
                    'id'
                ]; ?>">編集</a></th>
                <th><a href="/task/deletion.php?id=<?php echo $task[
                    'id'
                ]; ?>">削除</a></th>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </body>
</html>
