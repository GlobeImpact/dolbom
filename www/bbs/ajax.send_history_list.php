<?php
include_once('./_common.php');

$now_year = '';
$sch_value = '';

$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and code_menu = '{$_SESSION['this_code']}' and reg_date like '{$now_year}%'";

if($sch_value != '') {
    $where_str .= " and recv_hp like '%{$sch_value}%'";
}

$orderby_str .= " reg_date desc";

$sql = " select * from g5_sms_result where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $user_category = $row['user_category'];

        $list[$i]['idx'] = $row['idx'];
        $list[$i]['sms_category'] = '';

        switch ($user_category) {
            case 'member':
                $list[$i]['sms_category'] = '제공인력';
            break;

            case 'client':
                $list[$i]['sms_category'] = '고객';
            break;

            case 'manager':
                $list[$i]['sms_category'] = '매니저';
            break;

            default:
            break;
        }
        $list[$i]['recv_name'] = $row['recv_name'];
        $list[$i]['recv_hp'] = $row['recv_hp'];
        $list[$i]['booking'] = '';
        if($row['booking_datetime'] != '0000-00-00 00:00:00') $list[$i]['booking'] = 'Y';
        $list[$i]['booking_date'] = substr($row['booking_datetime'], 0, 16);
        if($row['booking_datetime'] == '0000-00-00 00:00:00') $list[$i]['booking_date'] = '';
        $list[$i]['send_message'] = nl2br($row['send_message']);
        $list[$i]['reg_date'] = substr($row['reg_date'], 0, 10);
    }
}

echo json_encode($list);