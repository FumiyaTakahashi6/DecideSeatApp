<?php
    session_start();

    ## 他のphpファイルを読み込む
    require_once(__DIR__ . '/config.php');
    require_once(__DIR__ . '/functions.php');
    require_once(__DIR__ . '/userdata.php');

    $DecideSeatApp = new \MyAPP\Todo();
    $user_table = $DecideSeatApp->getAll();

    function optionLoop($start, $end){	
        for($i = $start; $i <= $end; $i++){
            echo "<option value=\"{$i}\">{$i}</option>";
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8"> 
    <title>DecideSeatApp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="continue">
        <h1>DecideSeat</h1>
        <button>ユーザー追加</button>
    
        <form action="">
            <input type="text" id="new_name" placeholder="What needs to be done?">
            <input type="radio" name="gender" value="0">女性
            <input type="radio" name="gender" value="1">男性
            <label>生年月日: <input type="date" name="date"></label>
            <input id="new_todo_form" type="submit" value="送信する">
            <input type="reset" value="取消する">
        </form>
        
        <ul id="todos">
        <?php foreach($user_table as $user) : ?>
            <li id="todo_<?= h($user->id); ?>" data-id="<?= h($user->id); ?>">
                <span class="todo_title"><?= h($user->name); ?></span>
                <button >変更</button>
                <button class="delete_todo">削除</button>
       
                <form action="">
                    <input type="text" id="new_name" placeholder=<?= h($user->name); ?>>
                    <input type="radio" name="gender" value="0" <?php if ($user->gender === '0') { echo 'checked'; } ?>>女性 
                    <input type="radio" name="gender" value="1" <?php if ($user->gender === '1') { echo 'checked'; } ?>>男性
                    <label>生年月日: <input type="date" name="date" value=<?= h($user->birthday); ?>></label>
                    <input class="update_todo" type="submit" value="送信する">
                    <input type="reset" value="取消する">
                </form>
                <!-- <div class="delete_todo">×</div> -->
            </li>
        <?php endforeach; ?>
            <li id="todo_template" data-id="">
                <!-- <input type="checkbox" class="update_todo"> -->
                <span class="todo_title"></span>
                <button >変更</button>
                <button class="delete_todo">削除</button>
                <!-- <div class="delete_todo">×</div> -->
            </li>
        </ul>
    </div>
    <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
<script
src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="todo.js"></script>
</body>
</html>