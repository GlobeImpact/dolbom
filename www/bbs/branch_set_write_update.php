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
$reg_date = date('Y-m-d H:i:s');

if ($w == '') {
    $sql = " insert into g5_branch  
                set branch_name = '{$branch_name}', 
                reg_date = '{$reg_date}' ";
    if(sql_query($sql)) {
        $branch_id = sql_insert_id();

        if(count($menu_code) > 0) {
            for($mn=0; $mn<count($menu_code); $mn++) {
                $addr_sql = " insert into g5_branch_addr set branch_id = '{$branch_id}', menu_code = '{$menu_code[$mn]}', branch_addr = '{$branch_addr[$mn]}' ";
                sql_query($addr_sql);
            }
        }

        $list['msg'] = '등록이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_branch set 
                branch_name = '{$branch_name}' 
            where branch_id = '{$branch_id}' ";
    if(sql_query($sql)) {
        if(count($menu_code) > 0) {
            for($mn=0; $mn<count($menu_code); $mn++) {
                $addr_chk_sql = " select count(*) as cnt from g5_branch_addr where branch_id = '{$branch_id}' and menu_code = '{$menu_code[$mn]}' ";
                $addr_chk_row = sql_fetch($addr_chk_sql);
                if($addr_chk_row['cnt'] == 0) {
                    $addr_sql = " insert into g5_branch_addr set branch_id = '{$branch_id}', menu_code = '{$menu_code[$mn]}', branch_addr = '{$branch_addr[$mn]}' ";
                }else{
                    $addr_sql = " update g5_branch_addr set branch_addr = '{$branch_addr[$mn]}' where branch_id = '{$branch_id}' and menu_code = '{$menu_code[$mn]}' ";
                }
                sql_query($addr_sql);
            }
        }

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