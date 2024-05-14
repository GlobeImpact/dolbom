<?php
include_once('./_common.php');

$cl_service_period = $_POST['cl_service_period'];
$receipt_date = $_POST['receipt_date'];
$str_date = $_POST['str_date'];

$receipt_date_arr = explode('-', $receipt_date);
$receipt_year = $receipt_date_arr[0];

$str_date_arr = explode('-', $str_date);
$str_year = $str_date_arr[0];

$spp_year = $str_year;
if($spp_year == '') $spp_year = $receipt_year;

$sql = " select * from g5_service_period_price where spe_id = '{$cl_service_period}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$spp_year}' ";
$row = sql_fetch($sql);

$list['cl_unit_price'] = ($row['spp_deductible'] > 0)?$row['spp_deductible']:0;
if($cl_service_period == '') $list['cl_unit_price'] = 0;

echo json_encode($list);