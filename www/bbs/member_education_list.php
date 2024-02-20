<?php
$mn_cd = '10';
$mn_cd_sub = $mn_cd.'20';

include_once('./_common.php');

$g5['title'] = '교육정보관리 - 회원별보기';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/member/member_education_list.php';
include_once($skin_file);

include_once('./_tail.php');