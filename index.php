<?php
    session_start();

    ## 他のphpファイルを読み込む
    require_once(__DIR__ . '/config.php');
    require_once(__DIR__ . '/functions.php');
    require_once(__DIR__ . '/userdata.php');

    $DecideSeatApp = new \MyAPP\Todo();
    //　getUsers()に変更
    $user_table = $DecideSeatApp->getAll();
    //　getDepartments()に変更
    $department_table = $DecideSeatApp->getDepartment();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8"> 
    <title>DecideSeatApp</title>
    <link rel="stylesheet" href="styles.css">
    <a href=<?php echo APPURL."/index2.php"?>>参加者登録ページへ</a><br>
</head>
<body>
    <div id="continue">
        <h1>ユーザ管理ページ</h1>
        <button>ユーザー追加</button>
    
        <form action="">
            <input type="text" id="new_name" placeholder="名前">
            <input type="radio" name="gender" value="0" checked>該当なし
            <input type="radio" name="gender" value="1">女性
            <input type="radio" name="gender" value="2">男性
            <input type="date" name="date">
            <select id="department">
            <option value=0>該当なし</option>
            <?php foreach($department_table as $department) : ?>
                <option value="<?= h($department->id) ?>"><?= h($department->name); ?></option>
            <?php endforeach; ?>
            </select>
            <input id="new_todo_form" type="button" value="送信する">
        </form>
        
        <ul id="todos">
        <?php foreach($user_table as $user) : ?>
            <li id="todo_<?= h($user->id); ?>" data-id="<?= h($user->id); ?>">
                <span class="todo_title"><?= h($user->name); ?></span>
                <button >変更</button>
                <button class="delete_todo">削除</button>
       
                <form id="<?= h($user->id); ?>" action="">
                    <input type="text" id="chang_name" value="<?= h($user->name); ?>">
                    <input type="radio" name="gender" value="0" <?php if ($user->gender === '0') { echo 'checked'; } ?>>該当なし
                    <input type="radio" name="gender" value="1" <?php if ($user->gender === '1') { echo 'checked'; } ?>>女性 
                    <input type="radio" name="gender" value="2" <?php if ($user->gender === '2') { echo 'checked'; } ?>>男性
                    <input type="date" name="birthday_date" value=<?= h($user->birthday); ?>>
                    <select id="department">
                    <option value="0">該当なし</option>
                    <?php foreach($department_table as $department) : ?>
                        <option value="<?= h($department->id) ?>" <?php if ($user->department_id === $department->id) { echo 'selected'; } ?> ><?= h($department->name) ?></option>
                    <?php endforeach; ?>
                    </select>
                    <input class="update_todo" type="submit" value="送信する">
                </form>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
    <!-- 下に書く必要がない　-->
<script
src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="todo.js"></script>
</body>
</html>
