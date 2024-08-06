<?php
$mn_cd = '20';
$mn_cd_sub = $mn_cd.'50';

include_once('./_common.php');

$g5['title'] = '접수대장';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/client/client_recept.php';
include_once($skin_file);

include_once('./_tail.php');