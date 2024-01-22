<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$list = Array();

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if(!$is_member) {
    $list['msg'] = '로그인이 필요합니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

$heal_idx = $_POST['heal_idx'];
$set_idx = $_POST['set_idx'];
$heal_idx = $_POST['heal_idx'];
$mb_id = $_POST['mb_id'];
$heal_date = $_POST['heal_date'];
$heal_year = substr($heal_date, 0, 4);
$heal_reg_date = date('Y-m-d H:i:s');

if ($w == '') {
    $sql = " insert into g5_member_health 
                set set_mb_menu = '{$_SESSION['this_code']}', 
                set_idx = '{$set_idx}', 
                heal_year = '{$heal_year}', 
                heal_date = '{$heal_date}', 
                heal_mb_id = '{$mb_id}', 
                heal_reg_date = '{$heal_reg_date}' ";
    if(sql_query($sql)) {
        $heal_idx = sql_insert_id();

        $list['msg'] = '작성이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_member_health set 
            heal_year = '{$heal_year}', 
            heal_date = '{$heal_date}' 
            where heal_idx = '{$heal_idx}' and heal_mb_id = '{$mb_id}' ";
    if(sql_query($sql)) {
        $list['msg'] = '수정이 완료되었습니다';
        $list['code'] = '0000';
    }else{
        $list['msg'] = '수정에 실패하였습니다';
        $list['code'] = '9999';
    }
}

$list['w'] = $w;
$list['heal_idx'] = $heal_idx;

echo json_encode($list);
exit;