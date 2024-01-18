<?php
include_once('./_common.php');

$payment_ymd_arr = explode('/', $_POST['v_payment_ymd']);
$payment_year = $payment_ymd_arr[0];
$payment_month = $payment_ymd_arr[1];
$payment_day = $payment_ymd_arr[2];

$list = Array();

$sql = " update g5_pay_set set 
    payment_year = '{$payment_year}', 
    payment_month = '{$payment_month}', 
    payment_day = '{$payment_day}', 
    info_cell1 = '{$_POST['v_info_cell1']}', 
    info_cell2 = '{$_POST['v_info_cell2']}', 
    info_cell3 = '{$_POST['v_info_cell3']}', 
    item_cell1 = '{$_POST['v_item_cell1']}', 
    item_cell2 = '{$_POST['v_item_cell2']}', 
    item_cell3 = '{$_POST['v_item_cell3']}', 
    item_cell4 = '{$_POST['v_item_cell4']}', 
    item_cell5 = '{$_POST['v_item_cell5']}', 
    item_cell6 = '{$_POST['v_item_cell6']}', 
    add_cell1 = '{$_POST['v_add_cell1']}', 
    add_cell2 = '{$_POST['v_add_cell2']}', 
    add_cell3 = '{$_POST['v_add_cell3']}', 
    add_cell4 = '{$_POST['v_add_cell4']}', 
    add_cell5 = '{$_POST['v_add_cell5']}', 
    add_cell6 = '{$_POST['v_add_cell6']}', 
    add_cell7 = '{$_POST['v_add_cell7']}', 
    service_cell1 = '{$_POST['v_service_cell1']}', 
    service_cell2 = '{$_POST['v_service_cell2']}', 
    service_cell3 = '{$_POST['v_service_cell3']}', 
    service_cell4 = '{$_POST['v_service_cell4']}', 
    service_cell5 = '{$_POST['v_service_cell5']}', 
    service_cell6 = '{$_POST['v_service_cell6']}', 
    holiday_cell1 = '{$_POST['v_holiday_cell1']}', 
    holiday_cell2 = '{$_POST['v_holiday_cell2']}', 
    holiday_cell3 = '{$_POST['v_holiday_cell3']}', 
    holiday_cell4 = '{$_POST['v_holiday_cell4']}', 
    outsourcing_cell1 = '{$_POST['v_outsourcing_cell1']}', 
    outsourcing_cell2 = '{$_POST['v_outsourcing_cell2']}', 
    outsourcing_cell3 = '{$_POST['v_outsourcing_cell3']}', 
    outsourcing_cell4 = '{$_POST['v_outsourcing_cell4']}', 
    major4_company_cell1 = '{$_POST['v_major4_company_cell1']}', 
    major4_company_cell2 = '{$_POST['v_major4_company_cell2']}', 
    major4_company_cell3 = '{$_POST['v_major4_company_cell3']}', 
    major4_company_cell4 = '{$_POST['v_major4_company_cell4']}', 
    major4_company_cell5 = '{$_POST['v_major4_company_cell5']}', 
    major4_staff_cell1 = '{$_POST['v_major4_staff_cell1']}', 
    major4_staff_cell2 = '{$_POST['v_major4_staff_cell2']}', 
    major4_staff_cell3 = '{$_POST['v_major4_staff_cell3']}', 
    major4_staff_cell4 = '{$_POST['v_major4_staff_cell4']}', 
    major4_staff_cell5 = '{$_POST['v_major4_staff_cell5']}' 
where set_idx = '{$_POST['set_idx']}' ";
if(sql_query($sql)) {
    $list['code'] = '0000';
}else{
    $list['code'] = '9999';
}

$list['sql'] = $sql;
$list['post'] = $_POST;

echo json_encode($list);
