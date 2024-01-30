<?php
$mn_cd = 'branch';

include_once('./_common.php');

if(!$is_admin) {
    alert('최고관리자만 접근할 수 있습니다.', G5_URL);
    exit;
}

$g5['title'] = '지점 설정';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/branch/branch_set.php';
include_once($skin_file);

include_once('./_tail.php');