<?php
$mn_cd = '40';
$mn_cd2 = '4030';
$mn_cd_sub = 'pay';

include_once('./_common.php');

$g5['title'] = '급여계산';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/pay/pay.php';
include_once($skin_file);

include_once('./_tail.php');