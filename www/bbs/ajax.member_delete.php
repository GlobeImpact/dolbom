<?php
include_once('./_common.php');

$mb_id = $_POST['mb_id'];

$list = Array();

$sql = " update g5_member set mb_hide = 'y' where mb_id = '{$mb_id}' ";
if(sql_query($sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);