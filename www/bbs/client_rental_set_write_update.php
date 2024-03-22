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

$set_idx = isset($_POST['set_idx']) ? trim($_POST['set_idx']) : '';
$set_tit = isset($_POST['set_tit']) ? trim($_POST['set_tit']) : '';

if ($w == '') {
    $sql = " insert into g5_client_rental_set 
                set branch_id = '{$_SESSION['this_branch_id']}', set_mb_menu = '{$_SESSION['this_code']}', set_tit = '{$set_tit}' ";
    if(sql_query($sql)) {
        $list['msg'] = '대여품 리스트 추가가 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_client_rental_set 
        set set_tit = '{$set_tit}' 
            where set_idx = '{$set_idx}' ";
    sql_query($sql);

    $list['msg'] = '대여품 리스트 수정이 완료되었습니다';
    $list['code'] = '0000';
}

echo json_encode($list);
exit;