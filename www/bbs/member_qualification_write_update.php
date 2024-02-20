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
if($member['mb_level'] < 5) {
    $list['msg'] = '매니저 또는 관리자 접속이 필요합니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

// 매니저 등록/수정 권한 확인
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'write' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $list['msg'] = '등록/수정 권한이 없습니다.';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }
}

$w = $_POST['w'];
$set_idx = $_POST['set_idx'];
$idx = $_POST['idx'];
$now_year = $_POST['now_year'];
$mb_id = $_POST['mb_id'];
$reg_date = date('Y-m-d H:i:s');

$diagnosis_date = $_POST['diagnosis_date'];
$judgment_date = $_POST['judgment_date'];
$confirm_date = $_POST['confirm_date'];

$user_sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$user_row = sql_fetch($user_sql);

if ($w == '') {
    $sql = " insert into g5_member_qualification 
                set set_branch_id = '{$user_row['branch_id']}', 
                set_mb_menu = '{$user_row['mb_menu']}', 
                set_idx = '{$set_idx}', 
                input_year = '{$now_year}', 

                diagnosis_date = '{$diagnosis_date}', 
                judgment_date = '{$judgment_date}', 
                confirm_date = '{$confirm_date}', 
                mb_id = '{$mb_id}', 
                reg_date = '{$reg_date}' ";
    if(sql_query($sql)) {
        $idx = sql_insert_id();

        $list['msg'] = '작성이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_member_qualification set 
            diagnosis_date = '{$diagnosis_date}', 
            judgment_date = '{$judgment_date}', 
            confirm_date = '{$confirm_date}' 
            where idx = '{$idx}' and mb_id = '{$mb_id}' ";
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