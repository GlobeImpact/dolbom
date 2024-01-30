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

$w = $_POST['w'];
$idx = $_POST['idx'];
$now_year = $_POST['now_year'];
$comp_date = $_POST['comp_date'];
$comp_category = $_POST['comp_category'];
$take_category = $_POST['take_category'];
$comp_client_idx = $_POST['comp_client_idx'];
$comp_client_name = $_POST['comp_client_name'];
$take_date = $_POST['take_date'];
if($take_category != '' && $take_date == '') $take_date = date('Y-m-d');
$comp_content = $_POST['comp_content'];
$take_content = $_POST['take_content'];
$take_etc = $_POST['take_etc'];
$reg_date = date('Y-m-d H:i:s');

if ($w == '') {
    $sql = " insert into g5_client_complaints 
                set set_mb_menu = '{$_SESSION['this_code']}', 
                comp_date = '{$comp_date}', 
                comp_category = '{$comp_category}', 
                comp_client_idx = '{$comp_client_idx}', 
                comp_client_name = '{$comp_client_name}', 
                comp_content = '{$comp_content}', 
                take_date = '{$take_date}', 
                take_category = '{$take_category}', 
                take_content = '{$take_content}', 
                take_etc = '{$take_etc}', 
                reg_date = '{$reg_date}' ";
    if(sql_query($sql)) {
        $idx = sql_insert_id();

        $list['msg'] = '등록이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_client_complaints set 
                comp_category = '{$comp_category}', 
                comp_client_idx = '{$comp_client_idx}', 
                comp_client_name = '{$comp_client_name}', 
                comp_content = '{$comp_content}', 
                take_date = '{$take_date}', 
                take_category = '{$take_category}', 
                take_content = '{$take_content}', 
                take_etc = '{$take_etc}' 
            where idx = '{$idx}' ";
    if(sql_query($sql)) {
        $list['msg'] = '수정이 완료되었습니다';
        $list['code'] = '0000';
    }else{
        $list['msg'] = '수정에 실패하였습니다';
        $list['code'] = '9999';
    }
}

$list['w'] = $w;
$list['idx'] = $idx;

echo json_encode($list);
exit;