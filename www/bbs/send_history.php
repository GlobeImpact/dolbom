<?php
$mn_cd = '50';

include_once('./_common.php');

$g5['title'] = '문자전송내역';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/send/send_history.php';
include_once($skin_file);

include_once('./_tail.php');