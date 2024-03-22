<?php
include_once('./_common.php');

$list = Array();

$cl_service_cate2 = $_POST['cl_service_cate2'];

$period_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where sme_id = '{$cl_service_cate2}' and spe_week = 'weekdays' order by spe_period_hour asc, spe_period asc ";
$period_qry = sql_query($period_sql);
$period_num = sql_num_rows($period_qry);
if($period_num > 0) {
    for($i=0; $period_row = sql_fetch_array($period_qry); $i++) {
        $list[$i]['spe_id'] = $period_row['spe_id'];
        $list[$i]['spe_cate'] = $period_row['spe_cate'];
        $list[$i]['spe_name'] = $period_row['spe_name'];
        $list[$i]['spe_info'] = $period_row['spe_info'];
        $list[$i]['spe_period'] = $period_row['spe_period'];
    }
}

echo json_encode($list);