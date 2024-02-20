<?php
include_once('./_common.php');

$now_year = '';
$set_idx = '';

$now_year = $_POST['now_year'];
$set_idx = $_POST['set_idx'];

$list = Array();

$sql = " select * from g5_member_education where set_branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}' and set_idx = '{$set_idx}' and edu_year = '{$now_year}' order by edu_date desc, edu_str_hour desc, edu_tit asc ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);
if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list['menu'][$i]['idx'] = $row['idx'];
        $list['menu'][$i]['edu_tit'] = $row['edu_tit'];
    }
}else{
    $list['menu'] = '';
}

echo json_encode($list);