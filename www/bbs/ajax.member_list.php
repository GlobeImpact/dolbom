<?php
include_once('./_common.php');

$sch_activity_status = '';
$sch_service_category = '';
$sch_mb_name = '';
$mb_id = $_POST['mb_id'];

if($mb_id == '') {
    $sch_activity_status = $_POST['sch_activity_status'];
    $sch_service_category = $_POST['sch_service_category'];
    $sch_mb_name = $_POST['sch_mb_name'];
}

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}'";

if($sch_activity_status != '') {
    $where_str .= " and activity_status = '{$sch_activity_status}'";
}

if($sch_service_category != '') {
    $where_str .= " and service_category = '{$sch_service_category}'";
}

if($sch_mb_name != '') {
    $where_str .= " and mb_name like '%{$sch_mb_name}%'";
}

if($mb_id != '') {
    $orderby_str .= " mb_id = '{$mb_id}' desc, activity_status = '보류' desc, activity_status = '활동중' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";
}else{
    $orderby_str .= " activity_status = '보류' desc, activity_status = '활동중' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";
}

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

echo json_encode($list);