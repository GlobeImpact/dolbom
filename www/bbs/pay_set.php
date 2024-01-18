<?php
$mn_cd = '40';
$mn_cd2 = '4010';
$mn_cd_sub = 'pay_set';

include_once('./_common.php');

$g5['title'] = '공제항목설정';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/pay/pay_set.php';
include_once($skin_file);

include_once('./_tail.php');