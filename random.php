<?php

session_start();

## 他のphpファイルを読み込む
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/userdata.php');

try {
    if (isset($_POST["id"])) {
        $id = $_POST['id'];
        $table_seats = $_POST['table_seats'];
        print_r($id);
        print_r($table_seats);
        $DecideSeatApp = new \MyAPP\Todo();
        $user_table = $DecideSeatApp->getParticipant($id);
        
    } else {
        $id = '値が入力されていません';
    }
    // throw new PDOException();
} catch (PDOException $e) {
    exit($id.$e->getMessage());
}

    print_r($user_table)
?>