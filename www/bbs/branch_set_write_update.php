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

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if(!$is_admin) {
    $list['msg'] = '최고관리자만 접근할 수 있습니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

$w = $_POST['w'];
$branch_id = $_POST['branch_id'];
$branch_name = $_POST['branch_name'];
$menu_code = $_POST['menu_code'];
$branch_addr = $_POST['branch_addr'];
$branch_tel = $_POST['branch_tel'];
$branch_fax = $_POST['branch_fax'];
$branch_menu10 = $_POST['branch_menu10'];
$branch_menu20 = $_POST['branch_menu20'];
$reg_date = date('Y-m-d H:i:s');

if ($w == '') {
    $sql = " insert into g5_branch  
                set branch_name = '{$branch_name}', 
                branch_addr = '{$branch_addr}', 
                branch_tel = '{$branch_tel}', 
                branch_fax = '{$branch_fax}', 
                branch_menu10 = '{$branch_menu10}', 
                branch_menu20 = '{$branch_menu20}', 
                reg_date = '{$reg_date}' ";
    if(sql_query($sql)) {
        $branch_id = sql_insert_id();

        $list['msg'] = '등록이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_branch set 
                branch_name = '{$branch_name}', 
                branch_addr = '{$branch_addr}', 
                branch_tel = '{$branch_tel}', 
                branch_fax = '{$branch_fax}', 
                branch_menu10 = '{$branch_menu10}', 
                branch_menu20 = '{$branch_menu20}' 
            where branch_id = '{$branch_id}' ";
    if(sql_query($sql)) {
        $list['msg'] = '수정이 완료되었습니다';
        $list['code'] = '0000';
    }else{
        $list['msg'] = '수정에 실패하였습니다';
        $list['code'] = '9999';
    }
}

$list['w'] = $w;
$list['branch_id'] = $branch_id;

echo json_encode($list);
exit;