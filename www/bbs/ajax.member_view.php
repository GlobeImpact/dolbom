<?php
include_once('./_common.php');

// 주민번호로 만나이 계산
function wz_get_age($ymd = '') {
    if (!$ymd || empty($ymd)) {
        return false;
    }

    $birth = '';
    switch (substr(trim($ymd),7,1)) {
        case '1':
        case '2':
            $birth = '19'.substr(trim($ymd),0,2);
        break;
        case '3':
        case '4':
            $birth = '20'.substr(trim($ymd),0,2);
        break;
    }

    $age = '';
    if (!empty($birth)) {
        $today = date('Ymd');
        $birthday = $birth.substr(trim($ymd),2,4);
        $age = floor(($today - $birthday) / 10000);
    }

    return $age;
}

// 주민번호로 성별 계산
function wz_get_gender($ymd = '') {
    if (!$ymd || empty($ymd)) { 
        return false;
    }

    $gender = '';
    switch (substr(trim($ymd),7,1)) {
        case '1':
        case '3':
        case '5':
        case '7':
            $gender = '남';
        break;
        case '2':
        case '4':
        case '6':
        case '8':
            $gender = '여';
        break;
    }

    return $gender;
}

$mb_id = $_POST['mb_id'];

$list = Array();

$sql = " select * from g5_member where (1=1) and mb_level = 2 and mb_id = '{$mb_id}' and mb_hide = '' ";
$row = sql_fetch($sql);

$birthday = wz_get_age($row['security_number']);
$gender = wz_get_gender($row['security_number']);

$mb_tmp_dir = G5_DATA_URL.'/member_image/';
$mb_dir = $mb_tmp_dir.substr($mb_id,0,2);

$list['v_mb_profile'] = $mb_dir.'/'.$row['mb_profile'];
$list['v_mb_name'] = $row['mb_name'].' ('.$gender.'·'.$birthday.')';
$list['v_mb_hp'] = $row['mb_hp'];
$list['v_security_number'] = $row['security_number'];
$list['v_activity_status'] = $row['activity_status'];
$list['v_contract_type'] = $row['contract_type'];
$list['v_premium_use'] = ($row['premium_use'] == 'y')?'프리미엄':'';
$list['v_service_category'] = $row['service_category'];
$list['v_team_category'] = $row['team_category'];
$list['v_pet_use'] = $row['pet_use'];
$list['v_mb_addr'] = '['.$row['mb_zip1'].$row['mb_zip2'].'] '.$row['mb_addr1'].' '.$row['mb_addr2'];
$list['v_mb_memo'] = nl2br($row['mb_memo']);
$list['v_training_str_date1'] = $row['training_str_date1'];
$list['v_training_str_date2'] = $row['training_str_date2'];
$list['v_training_str_date3'] = $row['training_str_date3'];
$list['v_training_str_date4'] = $row['training_str_date4'];
$list['v_training_str_date5'] = $row['training_str_date5'];
$list['v_training_str_date6'] = $row['training_str_date6'];
$list['v_training_end_date1'] = $row['training_end_date1'];
$list['v_training_end_date2'] = $row['training_end_date2'];
$list['v_training_end_date3'] = $row['training_end_date3'];
$list['v_training_end_date4'] = $row['training_end_date4'];
$list['v_training_end_date5'] = $row['training_end_date5'];
$list['v_training_end_date6'] = $row['training_end_date6'];
$list['v_training_time1'] = $row['training_time1'];
$list['v_training_time2'] = $row['training_time2'];
$list['v_training_time3'] = $row['training_time3'];
$list['v_training_time4'] = $row['training_time4'];
$list['v_training_time5'] = $row['training_time5'];
$list['v_training_time6'] = $row['training_time6'];
$list['v_major4_insurance'] = $row['major4_insurance'];
$list['v_loss_insurance'] = $row['loss_insurance'];
$list['v_quit_date'] = $row['quit_date'];
$list['v_enter_date'] = $row['enter_date'];
$list['v_bank_name'] = $row['bank_name'];
$list['v_bank_account'] = $row['bank_account'];
$list['v_account_holder'] = $row['account_holder'];
$list['v_account_holder_etc'] = $row['account_holder_etc'];
$list['v_bank_info'] = $row['bank_name'].' : '.$row['bank_account'].'<br>'.$row['account_holder'];
if($row['account_holder_etc'] != '') $list['v_bank_info'] = $list['v_bank_info'].' ('.$row['account_holder_etc'].')';
$list['v_vulnerable'] = '';
if($row['vulnerable'] != '') {
    if($row['vulnerable'] == '기타') {
        $list['v_vulnerable'] .= $row['vulnerable_etc'];
    }else{
        $list['v_vulnerable'] .= $row['vulnerable'];
    }
}
$list['v_basic_price'] = number_format($row['basic_price']);
$list['v_monthly_income'] = number_format($row['monthly_income']);
$list['v_mb_memo2'] = nl2br($row['mb_memo2']);

if($row['major4_insurance'] == '0000-00-00') $list['v_major4_insurance'] = '';
if($row['loss_insurance'] == '0000-00-00') $list['v_loss_insurance'] = '';
if($row['quit_date'] == '0000-00-00') $list['v_quit_date'] = '';
if($row['enter_date'] == '0000-00-00') $list['v_enter_date'] = '';

$list['certificate'][] = '<a class="certificate_nav_list" mode="enter" target="_parent">재직증명서</a>';
$list['certificate'][] = '<a class="certificate_nav_list" mode="activity" target="_parent">활동증명서</a>';
if($list['v_enter_date'] != '' && $list['v_quit_date'] != '') $list['certificate'][] = '<a class="certificate_nav_list" mode="quit" target="_parent">퇴직확인원</a>';

echo json_encode($list);