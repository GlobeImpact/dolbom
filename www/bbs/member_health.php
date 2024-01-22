<?php
$mn_cd = '10';

include_once('./_common.php');

$g5['title'] = '건강검진정보관리';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/member/member_health.php';
include_once($skin_file);

include_once('./_tail.php');