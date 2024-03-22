<?php
include_once('./_common.php');

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and branch_hide = ''";

$orderby_str .= "branch_id desc";

$sql = " select * from g5_branch where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['branch_id'] = $row['branch_id'];
        $list[$i]['branch_name'] = $row['branch_name'];
        $list[$i]['branch_addr'] = $row['branch_addr'];
        $list[$i]['branch_tel'] = $row['branch_tel'];
        $list[$i]['branch_fax'] = $row['branch_fax'];
        $list[$i]['branch_menu10'] = $row['branch_menu10'];
        $list[$i]['branch_menu20'] = $row['branch_menu20'];

        /*
        $addr_sql = " select a.branch_addr, b.me_name from g5_branch_addr as a left join g5_menu as b on b.me_code = a.menu_code where branch_id = '{$row['branch_id']}' ";
        $addr_qry = sql_query($addr_sql);
        $addr_num = sql_num_rows($addr_qry);
        if($addr_num > 0) {
            for($j=0; $addr_row = sql_fetch_array($addr_qry); $j++) {
                $list[$i]['me_name'][$j] = $addr_row['me_name'];
                $list[$i]['branch_addr'][$j] = $addr_row['branch_addr'];
            }
        }
        */
    }
}

echo json_encode($list);