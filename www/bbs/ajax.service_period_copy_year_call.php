<?php
include_once('./_common.php');

$list = Array();

$branch_id = $_POST['branch_id'];

$sql = " select distinct spp_year from g5_service_period_price where branch_id = '{$branch_id}' order by spp_year desc ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);
if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['year'] = $row['spp_year'];
    }
}

echo json_encode($list);