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

$client_idx = $_POST['client_idx'];
$select_mb_id = $_POST['select_mb_id'][0];

$chk_sql = " select * from g5_work where client_idx = '{$client_idx}' ";
$chk_row = sql_fetch($chk_sql);

$reg_date = date('Y-m-d H:i:s');

if($chk_row['idx'] == '') {
    $sql = " insert into g5_work set client_idx = '{$client_idx}', mb_id = '{$select_mb_id}', status = '대기', reg_date = '{$reg_date}' ";
}else{
    $sql = " update g5_work set mb_id = '{$select_mb_id}' where idx = '{$chk_row['idx']}' ";
}

$list['mb_id'] = $select_mb_id;

if(sql_query($sql)) {
    if($chk_row['idx'] == '') {
        $idx = sql_insert_id();
    }else{
        $idx = $chk_row['idx'];
    }

    if($chk_row['mb_id'] != '' && $chk_row['mb_id'] != $select_mb_id) {
        $history_sql = " insert into g5_work_member_history set w_idx = '{$idx}', prev_mb_id = '{$chk_row['mb_id']}', change_mb_id = '{$select_mb_id}', reg_date = '{$reg_date}' ";
        sql_query($history_sql);
    }

    $list['code'] = '0000';
    $list['msg'] = '';
}else{
    $list['code'] = '9999';
    $list['msg'] = '저장에 실패하였습니다';
}

echo json_encode($list);
exit;