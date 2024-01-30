<?php
include_once('./_common.php');

$idx = '';

$idx = $_POST['idx'];

$list = Array();

$sql = " delete from g5_client_complaints where idx = '{$idx}' ";
if(sql_query($sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);
