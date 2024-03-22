<?php
$mn_cd = 'service_period';

include_once('./_common.php');

if(!$is_admin) {
    alert('최고관리자만 접근할 수 있습니다.', G5_URL);
    exit;
}

$g5['title'] = '고객 서비스 금액 관리';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/service_period/service_period.php';
include_once($skin_file);

include_once('./_tail.php');