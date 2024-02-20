<?php
include_once('./_common.php');

$mb_id = '';
$idx = '';

$mb_id = $_POST['mb_id'];
$idx = $_POST['idx'];

$sql = " delete from g5_member_education_list where idx = '{$idx}' and edul_mb_id = '{$mb_id}' ";
if(sql_query($sql)) {
    $list['msg'] = '미참여 설정되었습니다.';
    $list['code'] = '0000';
}else{
    $list['msg'] = '미참여 설정에 실패하였습니다.';
    $list['code'] = '9999';
}

echo json_encode($list);