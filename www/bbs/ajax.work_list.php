<?php
include_once('./_common.php');

$sch_service_cate = $_POST['sch_service_cate'];
$sch_str_receipt_date = $_POST['sch_str_receipt_date'];
$sch_end_receipt_date = $_POST['sch_end_receipt_date'];
$sch_cl_name = $_POST['sch_cl_name'];
$sch_cl_hp = $_POST['sch_cl_hp'];
$sch_status = $_POST['sch_status'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and client_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and cl_hide = ''";

if($sch_service_cate != '') {
    $where_str .= " and cl_service_cate = '{$sch_service_cate}'";
}

if($sch_str_receipt_date != '' && $sch_end_receipt_date != '') {
    $where_str .= " and (receipt_date >= '{$sch_str_receipt_date}' and receipt_date <= '{$sch_end_receipt_date}')";
}else if($sch_str_receipt_date != '') {
    $where_str .= " and receipt_date >= '{$sch_str_receipt_date}'";
}else if($sch_end_receipt_date != '') {
    $where_str .= " and receipt_date <= '{$sch_end_receipt_date}'";
}

if($sch_cl_name != '') {
    $where_str .= " and cl_name like '%{$sch_cl_name}%'";
}

if($sch_cl_hp != '') {
    $where_str .= " and replace(cl_hp,'-','') like '%{$sch_cl_hp}%'";
}

if($sch_status != '') {
    if($sch_status == '사용') {
        $where_str .= " and end_date = '0000-00-00' and cancel_date = '0000-00-00'";
    }else if($sch_status == '종료') {
        $where_str .= " and end_date != '0000-00-00'";
    }else if($sch_status == '취소') {
        $where_str .= " and cancel_date != '0000-00-00'";
    }
}

$orderby_str .= " receipt_date desc, cl_name asc";

$sql = " select * from g5_client where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['client_idx'] = $row['client_idx'];
        $list[$i]['use_status'] = '사용';
        if($row['end_date'] == '' || $row['end_date'] != '0000-00-00') $list[$i]['use_status'] = '종료';
        if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $list[$i]['use_status'] = '취소';
        $list[$i]['receipt_date'] = str_replace('-', '/', $row['receipt_date']);
        $list[$i]['client_service'] = $row['client_service'];

        $sca2_sql = " select * from g5_service_period where sme_id = '{$row['cl_service_cate2']}' ";
        $sca2_row = sql_fetch($sca2_sql);
        $list[$i]['cl_service_cate2'] = '';
        if($sca2_row['spe_name'] != '') $list[$i]['cl_service_cate2'] = $sca2_row['spe_name'];

        $spe_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where spe_id = '{$row['cl_service_period']}' ";
        $spe_row = sql_fetch($spe_sql);
        if($row['cl_service_cate'] == 10 || $row['cl_service_cate'] == 20) {
            $list[$i]['cl_service_period'] = ($spe_row['spe_info'] != '')?$spe_row['spe_info']:'';
        }else if($row['cl_service_cate'] == 30) {
            $list[$i]['cl_service_period'] = ($spe_row['spe_name'] != '')?$spe_row['spe_name']:'';
        }else{
            $list[$i]['cl_service_period'] = ($spe_row['spe_cate'] != '')?$spe_row['spe_cate']:'';
        }

        $list[$i]['cl_name'] = $row['cl_name'];
        $list[$i]['cl_hp'] = $row['cl_hp'];
        $list[$i]['cl_security_number'] = substr($row['cl_security_number'], 0, 8);
        $list[$i]['receipt_date'] = $row['receipt_date'];
        $list[$i]['str_date'] = ($row['str_date'] == '0000-00-00')?'':$row['str_date'];
        $list[$i]['end_date'] = ($row['end_date'] == '0000-00-00')?'':$row['end_date'];
        $list[$i]['cancel_date'] = ($row['cancel_date'] == '0000-00-00')?'':$row['cancel_date'];
        $list[$i]['cctv'] = $row['cl_cctv'];
        $list[$i]['pet'] = $row['cl_pet'];
        $list[$i]['prior_interview'] = $row['cl_prior_interview'];

        $list[$i]['area_x'] = $row['cl_area_x'];
        $list[$i]['area_y'] = $row['cl_area_y'];
    }
}

echo json_encode($list);