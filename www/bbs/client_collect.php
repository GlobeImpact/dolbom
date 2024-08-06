<?php
$mn_cd = '20';
$mn_cd_sub = $mn_cd.'40';

include_once('./_common.php');

$g5['title'] = '수급관리';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/client/client_collect.php';
include_once($skin_file);

include_once('./_tail.php');