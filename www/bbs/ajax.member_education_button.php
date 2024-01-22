<?php
include_once('./_common.php');

$list = Array();

$set_sql = " select * from g5_member_education_set where set_hide = '' order by set_idx asc ";
$set_qry = sql_query($set_sql);
$set_num = sql_num_rows($set_qry);

if($set_num > 0) {
    for($i=0; $set_row = sql_fetch_array($set_qry); $i++) {
        $list[$i]['set_idx'] = $set_row['set_idx'];
        $list[$i]['set_tit'] = $set_row['set_tit'];
    }
}

echo json_encode($list);