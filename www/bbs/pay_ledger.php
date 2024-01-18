<?php
$mn_cd = '40';
$mn_cd2 = '4040';
$mn_cd_sub = 'pay_ledger';

include_once('./_common.php');

$g5['title'] = '급여대장';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/pay/pay_ledger.php';
include_once($skin_file);

include_once('./_tail.php');