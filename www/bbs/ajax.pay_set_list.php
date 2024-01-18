<?php
include_once('./_common.php');

$sch_contract_type = '';
$sch_year = '';
$sch_month = '';
$set_idx = $_POST['set_idx'];

if($set_idx == '') {
    $sch_contract_type = $_POST['sch_contract_type'];
    $sch_year = $_POST['sch_year'];
    $sch_month = $_POST['sch_month'];
}

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}'";

if($sch_contract_type != '') {
    $where_str .= " and contract_type = '{$sch_contract_type}'";
}

if($sch_year != '') {
    $where_str .= " and set_year = '{$sch_year}'";
}

if($sch_month != '') {
    $where_str .= " and set_month = '{$sch_month}'";
}

if($set_idx != '') {
    $orderby_str .= " set_idx = '{$set_idx}' desc, set_year desc, set_month desc, contract_type asc";
}else{
    $orderby_str .= " set_year desc, set_month desc, contract_type asc";
}

$sql = " select * from g5_pay_set where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['set_idx'] = $row['set_idx'];
        $list[$i]['contract_type'] = $row['contract_type'];
        $list[$i]['set_year'] = $row['set_year'];
        $list[$i]['set_month'] = $row['set_month'];
        $list[$i]['payment_year'] = $row['payment_year'];
        $list[$i]['payment_month'] = $row['payment_month'];
        $list[$i]['payment_day'] = $row['payment_day'];

        if($set_idx != '' && $set_idx == $row['set_idx']) {
            $list[$i]['list_selected'] = 'y';
        }else{
            if($set_idx == '' && $i == 0) {
                $list[$i]['list_selected'] = 'y';
            }else{
                $list[$i]['list_selected'] = '';
            }
        }
    }
}

echo json_encode($list);