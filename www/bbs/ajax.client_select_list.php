<?php
include_once('./_common.php');

$idx = $_POST['idx'];
if($idx == '0') $idx = '';
$sch_value2 = $_POST['sch_value2'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and branch_id = '{$_SESSION['this_branch_id']}' and client_menu = '{$_SESSION['this_code']}'";

if($sch_value2 != '') {
    $where_str .= " and cl_name like '%{$sch_value2}%'";
}

// 우선순위 : 사용 > 종료 > 취소 > 이름순
$orderby_str .= " cancel_date = '0000-00-00' desc, end_date = '0000-00-00' desc, cancel_date desc, end_date desc, cl_name asc";

$sql = " select * from g5_client where (1=1) and cl_hide = '' {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['client_idx'] = $row['client_idx'];
        $list[$i]['cl_name'] = $row['cl_name'];
        $list[$i]['client_service'] = $row['client_service'];
        $list[$i]['cl_hp'] = $row['cl_hp'];
        $list[$i]['use_status'] = '사용';
        if($row['end_date'] == '' || $row['end_date'] != '0000-00-00') $list[$i]['use_status'] = '종료';
        if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $list[$i]['use_status'] = '취소';

        if($idx != '' && $idx == $row['client_idx']) {
            $list[$i]['list_selected'] = 'y';
        }else{
            $list[$i]['list_selected'] = '';
        }
    }
}

echo json_encode($list);