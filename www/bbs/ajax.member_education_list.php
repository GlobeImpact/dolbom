<?php
include_once('./_common.php');

$now_year = '';
$sch_value = '';

$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];

$list = Array();

$set_sql = " select * from g5_member_education_set order by set_idx asc ";
$set_qry = sql_query($set_sql);
$set_num = sql_num_rows($set_qry);

if($set_num > 0) {
    for($i=0; $set_row = sql_fetch_array($set_qry); $i++) {
        $sql = " select * from g5_member_education where set_idx = '{$set_row['set_idx']}' ";
    }
}

/*
$sql = " select * from g5_member where (1=1) and mb_level = 2 and mb_hide = '' {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $mb_addr1 = $row['mb_addr1'];
        $mb_addr = explode(' ', $mb_addr1, 3);
        $list[$i]['mb_no'] = $row['mb_no'];
        $list[$i]['mb_id'] = $row['mb_id'];
        $list[$i]['activity_status'] = $row['activity_status'];
        $list[$i]['mb_name'] = $row['mb_name'];
        $list[$i]['service_category'] = $row['service_category'];
        $list[$i]['team_category'] = $row['team_category'];
        $list[$i]['mb_addr'] = $mb_addr[0].' '.$mb_addr[1];

        if($mb_id != '' && $mb_id == $row['mb_id']) {
            $list[$i]['list_selected'] = 'y';
        }else{
            if($mb_id == '' && $i == 0) {
                $list[$i]['list_selected'] = 'y';
            }else{
                $list[$i]['list_selected'] = '';
            }
        }
    }
}
*/

echo json_encode($list);