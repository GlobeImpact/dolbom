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
$client_service = $_POST['client_service'];
$date_selected = $_POST['date_selected'];
$str_hour = $_POST['str_hour'];
$end_hour = $_POST['end_hour'];
$mb_id = $_POST['mb_id'];
$now_month = $_POST['now_month'];
$now_year = $_POST['now_year'];
$spe_period = $_POST['spe_period'];
$spe_period_hour = $_POST['spe_period_hour'];

$total_date = count($date_selected);

$work_sql = " select * from g5_work where client_idx = '{$client_idx}' ";
$work_row = sql_fetch($work_sql);
$work_idx = $work_row['idx'];

$now_date = date('Y-m-d');

if($client_service == '아가마지') {
    //
}

if($client_service == '베이비시터') {
    //
}

if($client_service == '청소') {
    //
}

if($client_service == '반찬') {
    //
}

$sql = " update g5_work set client_service = '{$client_service}', total_date = '{$total_date}' where client_idx = '{$client_idx}' ";
sql_query($sql);

if(count($date_selected) > 0) {

    $set_update_sql = " update g5_work_selected set selected_update = 'update' where work_idx = '{$work_idx}' and client_idx = '{$client_idx}' and selected_date >= '{$now_date}' ";
    sql_query($set_update_sql);

    for($i=0; $i<count($date_selected); $i++) {
        $selected_date_mk = strtotime($date_selected[$i]);

        $call_sql = " select * from g5_work_selected where work_idx = '{$work_idx}' and client_idx = '{$client_idx}' and selected_date = '{$date_selected[$i]}' ";
        $call_row = sql_fetch($call_sql);

        if($call_row['idx'] == '') {
            $add_sql = " insert into g5_work_selected set work_idx = '{$work_idx}', client_idx = '{$client_idx}', mb_id = '{$mb_id}', selected_date = '{$date_selected[$i]}', selected_date_mk = '{$selected_date_mk}', str_hour = '{$str_hour[$i]}', end_hour = '{$end_hour[$i]}', selected_update = '' ";
        }else{
            $add_sql = " update g5_work_selected set selected_update = '' where idx = '{$call_row['idx']}' and work_idx = '{$work_idx}' and selected_date = '{$date_selected[$i]}' ";
        }

        sql_query($add_sql);
    }

    $set_delete_sql = " delete from g5_work_selected where work_idx = '{$work_idx}' and client_idx = '{$client_idx}' and selected_update = 'update' ";
    sql_query($set_delete_sql);

    $list['code'] = '0000';
    $list['msg'] = '파견등록이 접수되었습니다.';
}else{
    $list['code'] = '9999';
    $list['msg'] = '변경된 내역이 없습니다.';
}

echo json_encode($list);
exit;