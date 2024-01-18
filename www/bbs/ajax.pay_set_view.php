<?php
include_once('./_common.php');

$set_idx = $_POST['set_idx'];

$list = Array();

$sql = " select * from g5_pay_set where (1=1) and set_idx = '{$set_idx}' ";
$row = sql_fetch($sql);

$list['v_contract_type'] = $row['contract_type'];
$list['v_set_ym'] = $row['set_year'].'/'.$row['set_month'];
$list['v_payment_ymd'] = $row['payment_year'].'/'.$row['payment_month'].'/'.$row['payment_day'];

$list['v_info_cell1'] = $row['info_cell1'];
$list['v_info_cell2'] = $row['info_cell2'];
$list['v_info_cell3'] = $row['info_cell3'];
$list['v_item_cell1'] = $row['item_cell1'];
$list['v_item_cell2'] = $row['item_cell2'];
$list['v_item_cell3'] = $row['item_cell3'];
$list['v_item_cell4'] = $row['item_cell4'];
$list['v_item_cell5'] = $row['item_cell5'];
$list['v_item_cell6'] = $row['item_cell6'];
$list['v_add_cell1'] = $row['add_cell1'];
$list['v_add_cell2'] = $row['add_cell2'];
$list['v_add_cell3'] = $row['add_cell3'];
$list['v_add_cell4'] = $row['add_cell4'];
$list['v_add_cell5'] = $row['add_cell5'];
$list['v_add_cell6'] = $row['add_cell6'];
$list['v_add_cell7'] = $row['add_cell7'];
$list['v_service_cell1'] = $row['service_cell1'];
$list['v_service_cell2'] = $row['service_cell2'];
$list['v_service_cell3'] = $row['service_cell3'];
$list['v_service_cell4'] = $row['service_cell4'];
$list['v_service_cell5'] = $row['service_cell5'];
$list['v_service_cell6'] = $row['service_cell6'];
$list['v_holiday_cell1'] = $row['holiday_cell1'];
$list['v_holiday_cell2'] = $row['holiday_cell2'];
$list['v_holiday_cell3'] = $row['holiday_cell3'];
$list['v_holiday_cell4'] = $row['holiday_cell4'];
$list['v_outsourcing_cell1'] = $row['outsourcing_cell1'];
$list['v_outsourcing_cell2'] = $row['outsourcing_cell2'];
$list['v_outsourcing_cell3'] = $row['outsourcing_cell3'];
$list['v_outsourcing_cell4'] = $row['outsourcing_cell4'];
$list['v_major4_company_cell1'] = $row['major4_company_cell1'];
$list['v_major4_company_cell2'] = $row['major4_company_cell2'];
$list['v_major4_company_cell3'] = $row['major4_company_cell3'];
$list['v_major4_company_cell4'] = $row['major4_company_cell4'];
$list['v_major4_company_cell5'] = $row['major4_company_cell5'];
$list['v_major4_staff_cell1'] = $row['major4_staff_cell1'];
$list['v_major4_staff_cell2'] = $row['major4_staff_cell2'];
$list['v_major4_staff_cell3'] = $row['major4_staff_cell3'];
$list['v_major4_staff_cell4'] = $row['major4_staff_cell4'];
$list['v_major4_staff_cell5'] = $row['major4_staff_cell5'];

echo json_encode($list);