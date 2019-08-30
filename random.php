<?php

session_start();

## 他のphpファイルを読み込む
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/userdata.php');

$DecideSeatApp = new \MyAPP\Todo();

try {
    if (isset($_POST["ids"])) {
        $ids = $_POST['ids'];
        $table_seats = $_POST['table_seats'];
        $department_data = $DecideSeatApp->getDepartment($ids);

        $participant_data_all = array();

        foreach($department_data as $index => $department){
            $department_id = h($department->department_id);
            $participant_data = $DecideSeatApp->getParticipant($ids,$department_id);
            $participant_data_all[$department_id] += $participant_data;
            print_r($participant_data_all);
            //print_r($participant_data_all);
            //print_r($participant_data_all);
            //h($department->department_id);
            //$department = $DecideSeatApp->($ids);
          }
        
    } else {
        $ids = '値が入力されていません';
    }
    // throw new PDOException();
} catch (PDOException $e) {
    exit($ids.$e->getMessage());
}

?>