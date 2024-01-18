<?php
include_once('./_common.php');

$yoil = array("일","월","화","수","목","금","토");

$now_time = date('Y').'년 '.date('m').'월 '.date('d').'일 ('.$yoil[date('w', strtotime(date('Y-m-d')))].') '.date('H').':'.date('i');

echo json_encode($now_time);
?>