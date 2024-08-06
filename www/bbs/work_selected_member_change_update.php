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

$change_check = $_POST['change_check'];
$change_mb_id = $_POST['change_mb_id'];
$work_idx = $_POST['work_idx'];

$reg_date = date('Y-m-d H:i:s');

if($change_mb_id != '' && count($change_check) > 0) {
    $work_sql = " select * from g5_work where idx = '{$work_idx}' ";
    $work_row = sql_fetch($work_sql);

    $work_history_update_sql = " insert into g5_work_member_history set w_idx = '{$work_idx}', prev_mb_id = '{$work_row['mb_id']}', change_mb_id = '{$change_mb_id}', reg_date = '{$reg_date}' ";
    sql_query($work_history_update_sql);

    $work_update_sql = " update g5_work set mb_id = '{$change_mb_id}' where idx = '{$work_idx}' ";
    sql_query($work_update_sql);

    for($i=0; $i<count($change_check); $i++) {
        $selected_update_sql = " update g5_work_selected set mb_id = '{$change_mb_id}' where idx = '{$change_check[$i]}' ";
        sql_query($selected_update_sql);
    }

    $list['code'] = '0000';
    $list['msg'] = '';
}else{
    $list['code'] = '9999';
    $list['msg'] = '저장에 실패하였습니다';
}

echo json_encode($list);
exit;