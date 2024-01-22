<?php
include_once('./_common.php');

$set_idx = $_POST['set_idx'];

$list = Array();

$sql = " update g5_member_education_set set set_hide = 'y' where set_idx = '{$set_idx}' ";
if(sql_query($sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);