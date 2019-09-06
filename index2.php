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
    <!-- 表示させるものは書かない -->
    <meta charset="utf-8"> 
    <title>DecideSeatApp2</title>
    <link rel="stylesheet" href="styles.css">
    <a href=<?php echo APPURL."/index.php"?>>ユーザー管理</a><br>
</head>
<body>
    <div id="continue">
        <h1>席決めアプリ</h1>
        <ol id="tables" type="1">
        <span>テーブル一覧</span>
            <li>
                <form action="">
                <input class="num" type="number" min="1" value="1">人席
                </form>
            </li>
        </ol>
        <input id="new_table" type="button" value="テーブルの追加">
        <input id="delete_table" type="button" value="テーブルの一括削除">

        <ul id=tables>
        <span>参加者一覧</span>
        </ul>

        <ul id="todos">
        <?php foreach($user_table as $user) : ?>
            <li id="todo_<?= h($user->id); ?>" data-id="<?= h($user->id); ?>">
                <input type="checkbox" name="sample" checked>
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