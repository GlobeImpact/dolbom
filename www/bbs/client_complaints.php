<?php
$mn_cd = '20';
$mn_cd_sub = $mn_cd.'30';

include_once('./_common.php');

$g5['title'] = '민원관리';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/client/client_complaints.php';
include_once($skin_file);

include_once('./_tail.php');