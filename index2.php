<?php
    session_start();

    ## 他のphpファイルを読み込む
    require_once(__DIR__ . '/config.php');
    require_once(__DIR__ . '/functions.php');
    require_once(__DIR__ . '/userdata.php');

    $DecideSeatApp = new \MyAPP\Todo();
    $user_table = $DecideSeatApp->getAll();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8"> 
    <title>DecideSeatApp2</title>
    <link rel="stylesheet" href="styles.css">
    <a href=<?php echo APPURL."/index.php"?>>ユーザー管理ページへ</a><br>
</head>
<body>
    <div id="continue">
        <h1>参加者登録ページ</h1>
        
        <form action="">
        <input id="num" type="number" min=0>
        <input id="new_table" type="button" value="追加">
        </form>
        <ul id=tables>
        </ul>

        <ul id="todos">
        <?php foreach($user_table as $user) : ?>
            <li id="todo_<?= h($user->id); ?>" data-id="<?= h($user->id); ?>">
                <input type="checkbox" name="sample">
                <span class="todo_title"><?= h($user->name); ?></span>
            </li>
        <?php endforeach; ?>
        </ul>
        <input id="shuffle_button" type="button"  value="シャッフル">
        <table id="seat_results">
        </table>
    </div>
    <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
<script
src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="todo.js"></script>
</body>
</html>