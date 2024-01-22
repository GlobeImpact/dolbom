<?php
include_once('./_common.php');

$rent_idx = $_POST['rent_idx'];

$list = Array();

$del_sql = " delete from g5_client_rental where rent_idx = '{$rent_idx}' ";
if(sql_query($del_sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);