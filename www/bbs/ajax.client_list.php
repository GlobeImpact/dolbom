<?php
include_once('./_common.php');

$sch_premium = '';
$sch_service_category = '';
$sch_cl_name = '';
$client_idx = $_POST['client_idx'];

if($client_idx == '') {
    $sch_premium = $_POST['sch_premium'];
    $sch_service_category = $_POST['sch_service_category'];
    $sch_cl_name = $_POST['sch_cl_name'];
}

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and client_menu = '{$_SESSION['this_code']}'";

if($sch_premium != '') {
    $where_str .= " and cl_premium_use = '{$sch_premium}'";
}

if($sch_service_category != '') {
    $where_str .= " and cl_service_cate = '{$sch_service_category}'";
}

if($sch_cl_name != '') {
    $where_str .= " and cl_name like '%{$sch_cl_name}%'";
}

if($client_idx != '') {
    $orderby_str .= " client_idx = '{$client_idx}' desc, cl_name asc";
}else{
    $orderby_str .= " cl_name asc";
}

$sql = " select * from g5_client where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['client_idx'] = $row['client_idx'];
        $list[$i]['cl_name'] = $row['cl_name'];
        $list[$i]['cl_hp'] = $row['cl_hp'];
        $list[$i]['receipt_date'] = str_replace('-', '/', $row['receipt_date']);
        $list[$i]['use_status'] = '사용';
        if($row['end_date'] == '' || $row['end_date'] != '0000-00-00') $list[$i]['use_status'] = '종료';
        if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $list[$i]['use_status'] = '취소';

        if($client_idx != '' && $client_idx == $row['client_idx']) {
            $list[$i]['list_selected'] = 'y';
        }else{
            if($client_idx == '' && $i == 0) {
                $list[$i]['list_selected'] = 'y';
            }else{
                $list[$i]['list_selected'] = '';
            }
        }
    }
}

echo json_encode($list);