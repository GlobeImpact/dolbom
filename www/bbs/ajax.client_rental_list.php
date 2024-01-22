<?php
include_once('./_common.php');

$rent_idx = $_POST['rent_idx'];
$sch_value2 = $_POST['sch_value2'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}'";

if($sch_value2 != '') {
    $where_str .= " and mb_name like '%{$sch_value2}%'";
}

$orderby_str .= " activity_status = '보류' desc, activity_status = '활동중' desc, mb_name asc";

$sql = " select * from g5_member where (1=1) and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['mb_no'] = $row['mb_no'];
        $list[$i]['mb_id'] = $row['mb_id'];
        $list[$i]['activity_status'] = $row['activity_status'];
        $list[$i]['mb_name'] = $row['mb_name'];
        $list[$i]['service_category'] = $row['service_category'];
        $list[$i]['team_category'] = $row['team_category'];
        $list[$i]['security_number'] = substr($row['security_number'], 0, 8);

        $edul_sql = " select * from g5_member_education_list where rent_idx = '{$rent_idx}' and edul_mb_id = '{$row['mb_id']}' limit 0, 1 ";
        $edul_row = sql_fetch($edul_sql);

        if($edul_row['edul_idx'] != '' && $rent_idx != '') {
            $list[$i]['list_selected'] = 'y';
        }else{
            $list[$i]['list_selected'] = '';
        }
    }
}

echo json_encode($list);