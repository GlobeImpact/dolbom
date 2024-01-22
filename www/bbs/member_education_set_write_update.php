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

$set_idx = isset($_POST['set_idx']) ? trim($_POST['set_idx']) : '';
$set_tit = isset($_POST['set_tit']) ? trim($_POST['set_tit']) : '';

if ($w == '') {
    $sql = " insert into g5_member_education_set 
                set set_tit = '{$set_tit}' ";
    if(sql_query($sql)) {
        $list['msg'] = '교육 리스트 추가가 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_member_education_set 
        set set_tit = '{$set_tit}' 
            where set_idx = '{$set_idx}' ";
    sql_query($sql);

    $list['msg'] = '교육 리스트 수정이 완료되었습니다';
    $list['code'] = '0000';
}

echo json_encode($list);
exit;