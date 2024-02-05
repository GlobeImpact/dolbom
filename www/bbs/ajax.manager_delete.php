<?php
include_once('./_common.php');

$mb_id = $_POST['mb_id'];

$list = Array();

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if(!$is_member) {
    $list['msg'] = '로그인이 필요합니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if(!$is_admin) {
    $list['msg'] = '최고관리자만 접근할 수 있습니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

$sql = " update g5_member set mb_hide = 'y' where mb_id = '{$mb_id}' and mb_level = 5 ";
if(sql_query($sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);