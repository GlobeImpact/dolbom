<?php
include_once('./_common.php');

$client_idx = $_POST['client_idx'];

$list = Array();

$sql = " select * from g5_client where (1=1) and cl_hide = '' and client_idx = '{$client_idx}' ";
$row = sql_fetch($sql);

$birthday = wz_get_age($row['cl_security_number']);
$gender = wz_get_gender($row['cl_security_number']);

$list['v_client_service'] = $row['client_service'];
$list['v_receipt_date'] = ($row['receipt_date'] == '0000-00-00')?'':$row['receipt_date'];
$list['v_str_date'] = ($row['str_date'] == '0000-00-00')?'':$row['str_date'];
$list['v_end_date'] = ($row['end_date'] == '0000-00-00')?'':$row['end_date'];
$list['v_cancel_date'] = ($row['cancel_date'] == '0000-00-00')?'':$row['cancel_date'];
$list['v_cl_name'] = $row['cl_name'].' ('.$gender.'·'.$birthday.')';
$list['v_cl_security_number'] = $row['cl_security_number'];
$list['v_cl_hp'] = $row['cl_hp'];
$list['v_cl_tel'] = $row['cl_tel'];
$list['v_cl_birth_type'] = $row['cl_birth_type'];
$list['v_cl_birth_due_date'] = ($row['cl_birth_due_date'] == '0000-00-00')?'':$row['cl_birth_due_date'];
$list['v_cl_birth_date'] = ($row['cl_birth_date'] == '0000-00-00')?'':$row['cl_birth_date'];
$list['v_cl_addr'] = '['.$row['cl_zip'].'] '.$row['cl_addr1'].' '.$row['cl_addr2'];

// 서비스분류
$service_menu_sql = " select * from g5_service_menu where sme_code = '{$row['cl_service_cate']}' and sme_use = 1 ";
$service_menu_row = sql_fetch($service_menu_sql);
$list['v_cl_service_cate'] = $service_menu_row['sme_name'];

// 서비스구분
$service_menu2_sql = " select * from g5_service_menu where sme_id = '{$row['cl_service_cate2']}' and sme_use = 1 ";
$service_menu2_row = sql_fetch($service_menu2_sql);
$list['v_cl_service_cate2'] = $service_menu2_row['sme_name'];

// 서비스기간
$service_period_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where spe_id = '{$row['cl_service_period']}' ";
$service_period_row = sql_fetch($service_period_sql);
if($row['cl_service_cate'] == 10 || $row['cl_service_cate'] == 20) {
    $list['v_cl_service_period'] = $service_period_row['spe_info'];
}else if($row['cl_service_cate'] == 30) {
    $list['v_cl_service_period'] = $service_period_row['spe_name'];
}else{
    $list['v_cl_service_period'] = $service_period_row['spe_cate'];
}

// 추가옵션
$service_option_sql = " select * from g5_service_option where sop_id = '{$row['cl_service_option']}' and sop_use = 1 order by sop_id asc ";
$service_option_row = sql_fetch($service_option_sql);
$list['v_cl_service_option'] = $service_option_row['sop_name'];

$list['v_cl_baby'] = $row['cl_baby'];
$list['v_cl_baby_gender'] = $row['cl_baby_gender'];
$list['v_cl_baby_count'] = $row['cl_baby_count'];
$list['v_cl_baby_first'] = ($row['cl_baby_first'] == 'y')?'있음':'없음';
$list['v_cl_school_preschool'] = '';
if($row['cl_school'] != '') $list['v_cl_school_preschool'] .= '취학 : '.$row['cl_school'].'명';
if($row['cl_school'] != '' && $row['cl_preschool'] != '') $list['v_cl_school_preschool'] .= ' / ';
if($row['cl_preschool'] != '') $list['v_cl_school_preschool'] .= '미취학 : '.$row['cl_preschool'].'명';
$list['v_cl_cctv'] = ($row['cl_cctv'] == 'y')?'있음':'없음';
$list['v_cl_pet'] = $row['cl_pet'];
$list['v_cl_surcharge'] = $row['cl_surcharge'];
$list['v_cl_unit_price'] = ($row['cl_unit_price'] == 0)?'':number_format($row['cl_unit_price']);
$list['v_cl_tot_price'] = ($row['cl_tot_price'] == 0)?'':number_format($row['cl_tot_price']);
$list['v_cl_cash_receipt'] = $row['cl_cash_receipt'];
$list['v_cl_memo1'] = nl2br($row['cl_memo1']);
$list['v_cl_memo2'] = nl2br($row['cl_memo2']);
$list['v_cl_memo3'] = nl2br($row['cl_memo3']);
$list['v_cl_relationship'] = $row['cl_relationship'];
$list['v_cl_baby_name'] = $row['cl_baby_name'];
$list['v_cl_baby_birth'] = $row['cl_baby_birth'];
$list['v_cl_prior_interview'] = $row['cl_prior_interview'];
$list['v_cl_overtime'] = ($row['cl_overtime'] == 'y')?'있음':'없음';
$list['v_cl_twins'] = ($row['cl_twins'] == 'y')?'있음':'없음';

echo json_encode($list);