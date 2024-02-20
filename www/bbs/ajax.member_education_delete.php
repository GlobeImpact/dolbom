<?php
include_once('./_common.php');

$idx = $_POST['idx'];

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

// 매니저 삭제 권한 확인
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'delete' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $list['msg'] = '삭제 권한이 없습니다.';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }
}

$list = Array();

$edul_del_sql = " delete from g5_member_education_list where idx = '{$idx}' ";
sql_query($edul_del_sql);

$del_sql = "delete from g5_member_education where idx = '{$idx}'";
if(sql_query($del_sql)) {
    $list['code'] = '0000';
    $list['msg'] = '삭제되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '삭제에 실패하였습니다.';
}

echo json_encode($list);