<?php
include_once('./_common.php');

$mb_id = '';
$idx = '';

$mb_id = $_POST['mb_id'];
$idx = $_POST['idx'];
$reg_date = date('Y-m-d H:i:s');

$chk_sql = " select count(*) as cnt from g5_member_education_list where idx = '{$idx}' and edul_mb_id = '{$mb_id}' ";
$chk_row = sql_fetch($chk_sql);
if($chk_row['cnt'] == 0) {
    $sql = " insert into g5_member_education_list set idx = '{$idx}', edul_mb_id = '{$mb_id}', edul_reg_date = '{$reg_date}' ";
    if(sql_query($sql)) {
        $list['msg'] = '참여 성공!';
        $list['code'] = '0000';
    }else{
        $list['msg'] = '참여에 실패하였습니다.';
        $list['code'] = '9999';
    }

}else{
    $list['msg'] = '이미 참여되어있습니다.';
    $list['code'] = '9999';
}

echo json_encode($list);