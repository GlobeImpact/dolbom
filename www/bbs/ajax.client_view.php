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

$client_idx = $_POST['client_idx'];

$list = Array();

$sql = " select * from g5_client where (1=1) and client_idx = '{$client_idx}' ";
$row = sql_fetch($sql);

$birthday = wz_get_age($row['cl_security_number']);
$gender = wz_get_gender($row['cl_security_number']);

$list['v_client_service'] = $row['client_service'];
$list['v_receipt_date'] = str_replace('-', '/', $row['receipt_date']);
$list['v_str_date'] = str_replace('-', '/', $row['str_date']);
$list['v_end_date'] = str_replace('-', '/', $row['end_date']);
$list['v_cancel_date'] = str_replace('-', '/', $row['cancel_date']);
$list['v_cl_name'] = $row['cl_name'].' ('.$gender.'·'.$birthday.')';
$list['v_cl_security_number'] = $row['cl_security_number'];
$list['v_cl_hp'] = $row['cl_hp'];
$list['v_cl_tel'] = $row['cl_tel'];
$list['v_cl_birth_type'] = $row['cl_birth_type'];
$list['v_cl_birth_due_date'] = $row['cl_birth_due_date'];
$list['v_cl_birth_date'] = $row['cl_birth_date'];
$list['v_cl_addr'] = '['.$row['cl_zip'].'] '.$row['cl_addr1'].' '.$row['cl_addr2'];
$list['v_cl_memo1'] = nl2br($row['cl_memo1']);
$list['v_cl_memo2'] = nl2br($row['cl_memo2']);

$list['v_cl_service_cate'] = '['.$row['client_service'].'] ';
$list['v_cl_service_cate'] .= $row['cl_service_cate'];
if($row['cl_service_cate'] == '바우처') $list['v_cl_service_cate'] .= ' : '.$row['cl_service_cate2'];
$list['v_cl_service_all_date'] = '';
if($row['cl_service_str_date'] != '' && $row['cl_service_str_date'] != '0000-00-00') $list['v_cl_service_all_date'] .= $row['cl_service_str_date'];
if($row['cl_service_str_date'] != '' && $row['cl_service_str_date'] != '0000-00-00' && $row['cl_service_end_date'] != '' && $row['cl_service_end_date'] != '0000-00-00') $list['v_cl_service_all_date'] .= ' ~ ';
if($row['cl_service_end_date'] != '' && $row['cl_service_end_date'] != '0000-00-00') $list['v_cl_service_all_date'] .= $row['cl_service_end_date'];
$list['v_cl_service_time'] = ($row['cl_service_time'] != '')?$row['cl_service_time'].'시간':'';
$list['v_cl_baby'] = $row['cl_baby'];
$list['v_cl_baby_gender'] = $row['cl_baby_gender'];
$list['v_cl_baby_count'] = $row['cl_baby_count'];
$list['v_cl_baby_first'] = $row['cl_baby_first'];
$list['v_cl_school_preschool'] = '';
if($row['cl_school'] != '') $list['v_cl_school_preschool'] .= '취학 : '.$row['cl_school'].'명';
if($row['cl_school'] != '' && $row['cl_preschool'] != '') $list['v_cl_school_preschool'] .= ' / ';
if($row['cl_preschool'] != '') $list['v_cl_school_preschool'] .= '미취학 : '.$row['cl_preschool'].'명';
$list['v_cl_cctv'] = ($row['cl_cctv'] == 'y')?'있음':'없음';
$list['v_cl_pet'] = $row['cl_pet'];
$list['v_cl_prior_interview'] = $row['cl_prior_interview'];
$list['v_cl_surcharge'] = $row['cl_surcharge'];
$list['v_cl_premium_use'] = ($row['cl_premium_use'] == 'y')?'사용':'미사용';
$list['v_cl_item1_use'] = $row['cl_item1_use'];
$list['v_cl_item1_num'] = $row['cl_item1_num'];
$list['v_cl_item1_date'] = $row['cl_item1_date'];
$list['v_cl_item1_name'] = $row['cl_item1_name'];
$list['v_cl_item1_return_date'] = $row['cl_item1_return_date'];
$list['v_cl_item1_return_name'] = $row['cl_item1_return_name'];
$list['v_cl_item1_use'] = $row['cl_item1_use'];
$list['v_cl_item1_num'] = $row['cl_item1_num'];
$list['v_cl_item1_date'] = $row['cl_item1_date'];
$list['v_cl_item1_name'] = $row['cl_item1_name'];
$list['v_cl_item1_return_date'] = $row['cl_item1_return_date'];
$list['v_cl_item1_return_name'] = $row['cl_item1_return_name'];
$list['v_cl_unit_price'] = number_format($row['cl_unit_price']);
$list['v_cl_tot_price'] = number_format($row['cl_tot_price']);
$list['v_cl_memo3'] = nl2br($row['cl_memo3']);
$list['v_cl_item1'] = '';
if($row['cl_item1_use'] == 'y') {
    $list['v_cl_item1'] .= '유축기 : ';
    $list['v_cl_item1'] .= $row['cl_item1_num'];
    $list['v_cl_item1'] .= ' / '.$row['cl_item1_date'];
    $list['v_cl_item1'] .= ' / '.$row['cl_item1_name'];
    if($row['cl_item1_return_date'] != '') {
        $list['v_cl_item1'] .= ' / '.$row['cl_item1_return_date'];
        $list['v_cl_item1'] .= ' / '.$row['cl_item1_return_name'];
    }
}
$list['v_cl_item2'] = '';
if($row['cl_item2_use'] == 'y') {
    $list['v_cl_item2'] .= '좌욕기 : ';
    $list['v_cl_item2'] .= $row['cl_item2_num'];
    $list['v_cl_item2'] .= ' / '.$row['cl_item2_date'];
    $list['v_cl_item2'] .= ' / '.$row['cl_item2_name'];
    if($row['cl_item2_return_date'] != '') {
        $list['v_cl_item2'] .= ' / '.$row['cl_item2_return_date'];
        $list['v_cl_item2'] .= ' / '.$row['cl_item2_return_name'];
    }
}

$list['v_cl_relationship'] = $row['cl_relationship'];
$list['v_cl_baby_name'] = $row['cl_baby_name'];
$list['v_cl_baby_birth'] = $row['cl_baby_birth'];
$list['v_cl_add_service0'] = $row['cl_add_service0'];
$list['v_cl_house_area'] = $row['cl_house_area'];
$list['v_cl_add_service1'] = $row['cl_add_service1'];
$list['v_cl_product'] = $row['cl_product'];
$list['v_cl_add_service2'] = $row['cl_add_service2'];

if($row['receipt_date'] == '0000-00-00') $list['v_major4_insurance'] = '';
if($row['str_date'] == '0000-00-00') $list['v_str_date'] = '';
if($row['end_date'] == '0000-00-00') $list['v_end_date'] = '';
if($row['cancel_date'] == '0000-00-00') $list['v_cancel_date'] = '';
if($row['cl_birth_due_date'] == '0000-00-00') $list['v_cl_birth_due_date'] = '';
if($row['cl_birth_date'] == '0000-00-00') $list['v_cl_birth_date'] = '';

if($row['cl_item1_return_date'] == '0000-00-00') $list['v_cl_item1_return_date'] = '';
if($row['cl_item1_return_date'] == '0000-00-00') $list['v_cl_item1_return_date'] = '';

echo json_encode($list);