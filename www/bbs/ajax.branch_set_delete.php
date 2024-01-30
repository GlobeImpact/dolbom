<?php
include_once('./_common.php');

$idx = '';

$branch_id = $_POST['branch_id'];

$list = Array();

$sql = " update g5_branch set branch_hide = 'y' where branch_id = '{$branch_id}' ";
if(sql_query($sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);
