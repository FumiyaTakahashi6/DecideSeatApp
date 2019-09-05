<?php

session_start();

## 他のphpファイルを読み込む
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/userdata.php');

$DecideSeatApp = new \MyAPP\Todo();

$error_msg = "";
// 参加者と座席数が入力されているか確認
if (!isset($_POST['ids']) || !isset($_POST['table_seats'])  ) {
    $error_msg = "参加者または、座席数が入力されていません";
    exit(json_encode($error_msg));
} 
$participant_sum = count($_POST['ids']);
$table_seats_sum = array_sum($_POST['table_seats']);
// 参加者と座席数が一致しているか確認
if ($participant_sum !== $table_seats_sum){
    $error_msg = '参加者と座席数が一致しません';
    exit(json_encode($error_msg));
}

$ids = $_POST['ids'];
$table_seats = $_POST['table_seats'];
$table_sum = count($_POST['table_seats']);

$department_id = array();
$shuffle_departmentData = array();
$shuffle_participantdata = array();
$seat_results = array();

$participant_data = $DecideSeatApp->getParticipant($ids);

foreach ($participant_data as $index => $value) {
    $department_id[$index] = $value->department_id;
}

$department_id = array_unique($department_id);
foreach ($participant_data as $index => $value1) {
    foreach ($department_id as $index => $value2) {
        if($value1->department_id === $value2) {
            $shuffle_departmentData[$value2][] = $value1;
        }
    }
}

foreach ($department_id as $index => $value3) {
    shuffle($shuffle_departmentData[$value3]);
    foreach ($shuffle_departmentData[$value3] as $index => $value4){
        $shuffle_participantdata[] = $value4;
    }
}

for ($i = 0; $i < count($shuffle_participantdata); $i++) {
    $table_num = $i % $table_sum;
    if($table_seats[$table_num] == "0"){
        $shuffle_participantdata[] = $shuffle_participantdata[$i];

    } else {
        $table_seats[$table_num] = $table_seats[$table_num] - 1;
        $seat_results[$table_num][] = $shuffle_participantdata[$i];
    }
}
echo json_encode($seat_results);

