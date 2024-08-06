<?php
include_once('./_common.php');

$mb_id = $_POST['mb_id'];

$list = Array();

$sql = " select * from g5_member where (1=1) and mb_level = 2 and mb_hide = '' and mb_id = '{$mb_id}' ";
$row = sql_fetch($sql);

$mb_tmp_dir = G5_DATA_URL.'/member_image/';
$mb_dir = $mb_tmp_dir.substr($mb_id,0,2);

$list['v_mb_profile'] = '';
if($row['mb_profile'] != '') $list['v_mb_profile'] .= $mb_dir.'/'.$row['mb_profile'];

$list['v_service_category'] = $row['service_category'];
$list['v_mb_name'] = $row['mb_name'];
if($row['security_number'] != '') {
    $list['v_mb_name'] .= ' (';
    $list['v_mb_name'] .= wz_get_gender($row['security_number']).'자';
    $list['v_mb_name'] .= '·'.wz_get_age($row['security_number']);
    $list['v_mb_name'] .= ')';
}
$list['v_mb_hp'] = $row['mb_hp'];
$list['v_activity_status'] = $row['activity_status'];
$list['v_security_number'] = $row['security_number'];
$list['v_contract_type'] = $row['contract_type'];
$list['v_team_category'] = $row['team_category'];
$list['v_premium_use'] = '';
if($row['premium_use'] == 'y') $list['v_premium_use'] = '<a class="premium_icon">P</a>';
$list['v_enter_date'] = '';
if($row['enter_date'] != '0000-00-00') $list['v_enter_date'] = $row['enter_date'];
$list['v_vulnerable'] = '';
if($row['vulnerable'] != '') {
    if($row['vulnerable'] == '기타') {
        $list['v_vulnerable'] .= $row['vulnerable_etc'];
    }else{
        $list['v_vulnerable'] .= $row['vulnerable'];
    }
}
$list['v_pet_use'] = $row['pet_use'];
$list['v_addr'] = '';
if($row['mb_zip1'] != '' || $row['mb_zip2'] != '') $list['v_addr'] .= '['.$row['mb_zip1'].$row['mb_zip2'].']';
if($row['mb_addr1'] != '') $list['v_addr'] .= ' '.$row['mb_addr1'];
if($row['mb_addr2'] != '') $list['v_addr'] .= ' '.$row['mb_addr2'];
$list['v_mb_memo'] = nl2br($row['mb_memo']);

$list['v_major4_insurance'] = '';
if($row['major4_insurance'] != '0000-00-00') $list['v_major4_insurance'] = $row['major4_insurance'];
$list['v_loss_insurance'] = '';
if($row['loss_insurance'] != '0000-00-00') $list['v_loss_insurance'] = $row['loss_insurance'];
$list['v_quit_date'] = '';
if($row['quit_date'] != '0000-00-00') $list['v_quit_date'] = $row['quit_date'];
$list['v_basic_price'] = number_format($row['basic_price']);
$list['v_monthly_income'] = number_format($row['monthly_income']);
$list['v_bank_name'] = $row['bank_name'];
$list['v_bank_account'] = $row['bank_account'];
$list['v_account_holder'] = $row['account_holder'];
$list['v_mb_memo2'] = nl2br($row['mb_memo2']);

$list['v_education_memo'] = $row['education_memo'];
$list['v_career_memo'] = $row['career_memo'];
$list['v_criminal_history'] = $row['criminal_history'];

if($row['mb_id'] != '') {
    if($row['activity_status'] == '활동중' || $row['activity_status'] == '휴직') {
        $list['certificate'][] = '<a class="certificate_nav_list" mode="enter" target="_parent">재직증명서</a>';
    }else if($row['activity_status'] == '퇴사'){
        $list['certificate'][] = '<a class="certificate_nav_list" mode="career" target="_parent">경력증명서</a>';
    }
    if($row['activity_status'] != '보류') $list['certificate'][] = '<a class="certificate_nav_list" mode="activity" target="_parent">활동증명서</a>';
    if($row['enter_date'] != '0000-00-00' && $row['quit_date'] != '0000-00-00') $list['certificate'][] = '<a class="certificate_nav_list" mode="quit" target="_parent">퇴직확인원</a>';
}

echo json_encode($list);