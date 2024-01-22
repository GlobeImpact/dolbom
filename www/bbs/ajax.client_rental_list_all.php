<?php
include_once('./_common.php');

$now_year = '';
$sch_value = '';
$set_idx = '';

$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];
$set_idx = $_POST['set_idx'];

$list = Array();

$where_str = "";
$orderby_str = "";

if($sch_value != '') {
    $where_str .= " and rent_name like '%{$sch_value}%'";
}

if($set_idx != '') {
    $where_str .= " and set_idx = '{$set_idx}'";
}

$orderby_str .= " rent_date desc, rent_name asc";

$sql = " select * from g5_client_rental where set_mb_menu = '{$_SESSION['this_code']}' and rent_year = '{$now_year}' {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $set_sql = " select * from g5_client_rental_set where set_idx = '{$row['set_idx']}' ";
        $set_row = sql_fetch($set_sql);

        $list[$i]['rent_idx'] = $row['rent_idx'];
        $list[$i]['set_idx'] = $row['set_idx'];
        $list[$i]['set_tit'] = $set_row['set_tit'];
        $list[$i]['rent_mb_id'] = $row['rent_mb_id'];
        $list[$i]['rent_return_mb_id'] = $row['rent_return_mb_id'];
        $list[$i]['rent_numb'] = $row['rent_numb'];
        $list[$i]['rent_date'] = $row['rent_date'];
        $list[$i]['rent_name'] = $row['rent_name'];
        $list[$i]['rent_return_date'] = $row['rent_return_date'];
        $list[$i]['rent_return_name'] = $row['rent_return_name'];
    }
}

echo json_encode($list);