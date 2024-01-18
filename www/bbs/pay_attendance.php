<?php
$mn_cd = '40';
$mn_cd2 = '4020';
$mn_cd_sub = 'pay_attendance';

include_once('./_common.php');

$g5['title'] = '근태관리';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/pay/pay_attendance.php';
include_once($skin_file);

include_once('./_tail.php');