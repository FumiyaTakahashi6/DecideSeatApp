<?php

session_start();

## 他のphpファイルを読み込む
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/userdata.php');

$DecideSeatApp = new \MyAPP\Todo();
// 参加者数
$participant_sum = count($_POST['ids']);
// 席数
$table_seats_sum = array_sum($_POST['table_seats']);

try {
    if ($participant_sum === $table_seats_sum) {
        $ids = $_POST['ids'];
        $table_seats = $_POST['table_seats'];
        $table_sum = count($_POST['table_seats']);

        $seat_results = array();

        $test = array();
        $test2 = array();
        $test3 = array();

        $participant_data = $DecideSeatApp->getParticipant($ids);

        // 部署ごとソート
        foreach ($participant_data as $index => $value) {
            $sort[$index] = $value->department_id;
        }
        array_multisort($sort, SORT_ASC, $participant_data);
        // テーブル座席数にしたがって振り分け

        /*
        foreach ($participant_data as $index => $value) {
            $test[$index] = $value->department_id;
        }
        $test = array_unique($test);
        foreach ($participant_data as $index => $value1) {
            foreach ($test as $index => $value2) {
                if($value1->department_id === $value2) {
                    $test2[$value2][] = $value1;
                }
            }
        }

        foreach ($test as $index => $value3) {
            shuffle($test2[$value3]);
            $test3[] = $test2[$value3];
            
        }
        for ($i = 0; $i < count($test3); $i++) {
            $table_num = $i % $table_sum;
            if($table_seats[$table_num] === 0){
                $test3[] = $test3[$i];

            } else {
                $table_seats[$table_num] = $table_seats[$table_num] - 1;
                $seat_results[$table_num][] = $test3[$i];
            }
        }
        print_r($seat_results);
        */
        
        for ($i = 0; $i < count($participant_data); $i++) {
            $table_num = $i % $table_sum;
            if($table_seats[$table_num] === 0){
                $participant_data[] = $participant_data[$i];

            } else {
                $table_seats[$table_num] = $table_seats[$table_num] - 1;
                $seat_results[$table_num][] = $participant_data[$i];
            }
        }
        echo json_encode($seat_results);
    } else {
        
    }
} catch (PDOException $e) {
    exit($e->getMessage());
}

?>