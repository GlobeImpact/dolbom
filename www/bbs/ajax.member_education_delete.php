<?php
include_once('./_common.php');

$edu_idx = $_POST['edu_idx'];

$list = Array();

$edul_del_sql = " delete from g5_member_education_list where edu_idx = '{$edu_idx}' ";
sql_query($edul_del_sql);

$del_sql = "delete from g5_member_education where edu_idx = '{$edu_idx}'";
if(sql_query($del_sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);