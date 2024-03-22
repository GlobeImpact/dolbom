<?php
include_once('./_common.php');

$now_year = '';
$sch_date = '';
$sch_value = '';

$now_year = $_POST['now_year'];
$sch_date = $_POST['sch_date'];
$sch_value = $_POST['sch_value'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}'";

if($sch_date != '') {
    $where_str .= " and comp_date = '{$sch_date}'";
}else{
    $where_str .= " and comp_date like '{$now_year}%'";
}

if($sch_value != '') {
    $where_str .= " and comp_client_name like '%{$sch_value}%'";
}

$orderby_str .= "take_category asc, take_date = '0000-00-00' desc, idx desc";

$sql = " select * from g5_client_complaints where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['idx'] = $row['idx'];
        $list[$i]['comp_date'] = $row['comp_date'];
        if($row['comp_date'] == '0000-00-00') $list[$i]['comp_date'] = '';
        $list[$i]['comp_category'] = $row['comp_category'];

        $list[$i]['comp_client_name'] = $row['comp_client_name'];

        $client_sql = " select * from g5_client where client_idx = '{$row['comp_client_idx']}' ";
        $client_row = sql_fetch($client_sql);

        $list[$i]['service_category'] = $client_row['client_service'];
        $list[$i]['tel'] = $client_row['cl_hp'];

        $list[$i]['status'] = '접수';
        if($row['take_date'] != '0000-00-00') $list[$i]['status'] = '처리완료';

        $list[$i]['take_date'] = $row['take_date'];
        if($row['take_date'] == '0000-00-00') $list[$i]['take_date'] = '';
    }
}

echo json_encode($list);