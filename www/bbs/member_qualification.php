<?php
$mn_cd = '10';
$mn_cd_sub = $mn_cd.'30';

include_once('./_common.php');

$g5['title'] = '자격정보관리';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/member/member_qualification.php';
include_once($skin_file);

include_once('./_tail.php');