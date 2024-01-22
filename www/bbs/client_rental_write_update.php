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

$rent_idx = $_POST['rent_idx'];
$set_idx = $_POST['set_idx'];
$rent_date = $_POST['rent_date'];
$rent_year = substr($rent_date, 0, 4);
$rent_mb_id = $_POST['rent_mb_id'];
$rent_return_mb_id = $_POST['rent_return_mb_id'];
$rent_numb = $_POST['rent_numb'];
$rent_name = $_POST['rent_name'];
$rent_return_date = $_POST['rent_return_date'];
$rent_return_name = $_POST['rent_return_name'];
$rent_reg_date = date('Y-m-d H:i:s');

if ($w == '') {
    $sql = " insert into g5_client_rental 
                set set_mb_menu = '{$_SESSION['this_code']}', 
                set_idx = '{$set_idx}', 
                rent_year = '{$rent_year}', 
                rent_mb_id = '{$rent_mb_id}', 
                rent_return_mb_id = '{$rent_return_mb_id}', 
                rent_numb = '{$rent_numb}', 
                rent_date = '{$rent_date}', 
                rent_name = '{$rent_name}', 
                rent_return_date = '{$rent_return_date}', 
                rent_return_name = '{$rent_return_name}', 
                rent_reg_date = '{$rent_reg_date}' ";
    if(sql_query($sql)) {
        $rent_idx = sql_insert_id();

        $list['msg'] = '작성이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_client_rental set 
                rent_year = '{$rent_year}', 
                rent_mb_id = '{$rent_mb_id}', 
                rent_return_mb_id = '{$rent_return_mb_id}', 
                rent_numb = '{$rent_numb}', 
                rent_date = '{$rent_date}', 
                rent_name = '{$rent_name}', 
                rent_return_date = '{$rent_return_date}', 
                rent_return_name = '{$rent_return_name}' 
            where rent_idx = '{$rent_idx}' ";
    if(sql_query($sql)) {
        $list['msg'] = '수정이 완료되었습니다';
        $list['code'] = '0000';
    }else{
        $list['msg'] = '수정에 실패하였습니다';
        $list['code'] = '9999';
    }
}

$list['w'] = $w;
$list['rent_idx'] = $rent_idx;

echo json_encode($list);
exit;