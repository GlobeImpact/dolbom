<?php
$mn_cd = 'setting';

include_once('./_common.php');

$g5['title'] = '시스템 설정';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/setting/setting.php';
include_once($skin_file);

include_once('./_tail.php');