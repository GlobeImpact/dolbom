<?php
include_once('./_common.php');

$mb_id = $_POST['mb_id'];
$sch_str_selected_date = $_POST['sch_str_selected_date'];
$sch_end_selected_date = $_POST['sch_end_selected_date'];

$yoil = array("일","월","화","수","목","금","토");

$list = Array();

$where_str = "";

if($sch_str_selected_date != '' && $sch_end_selected_date != '') {
    $where_str .= " and (selected_date >= '{$sch_str_selected_date}' and selected_date <= '{$sch_end_selected_date}')";
}else if($sch_str_selected_date != '') {
    $where_str .= " and (selected_date >= '{$sch_str_selected_date}')";
}else if($sch_end_selected_date != '') {
    $where_str .= " and (selected_date <= '{$sch_end_selected_date}')";
}

$sql = " select * from g5_work_selected where mb_id = '{$mb_id}' {$where_str} order by selected_date asc ";

$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $holiday_sql = " select count(*) as cnt from g5_holiday where h_date = '{$row['selected_date']}' and is_holiday = 'Y' ";
        $holiday_row = sql_fetch($holiday_sql);

        $mb_sql = " select * from {$g5['member_table']} where mb_id = TRIM('".$row['mb_id']."') ";
        $mb_row = sql_fetch($mb_sql);
        $list[$i]['mb_name'] = $mb_row['mb_name'];
        if($mb_row['security_number'] != '') {
            $list[$i]['mb_name'] .= ' (';
            $list[$i]['mb_name'] .= wz_get_gender($mb_row['security_number']).'자';
            $list[$i]['mb_name'] .= '·'.wz_get_age($mb_row['security_number']);
            $list[$i]['mb_name'] .= ')';
        }

        $list[$i]['idx'] = $row['idx'];
        $list[$i]['work_idx'] = $row['work_idx'];
        $list[$i]['client_idx'] = $row['client_idx'];
        $list[$i]['mb_id'] = $row['mb_id'];
        $list[$i]['selected_date'] = $row['selected_date'];
        $list[$i]['selected_date_mk'] = date('Ymd', $row['selected_date_mk']);
        $selected_date_mk = date('Ymd', $row['selected_date_mk']);
        $list[$i]['yoil'] = $yoil[date('w', strtotime($selected_date_mk))];
        $list[$i]['weekend'] = (date('w', strtotime($selected_date_mk)) == 0 || date('w', strtotime($selected_date_mk)) == 6 || $holiday_row['cnt'] > 0)?'Y':'N';
        $list[$i]['str_hour'] = $row['str_hour'];
        $list[$i]['end_hour'] = $row['end_hour'];

        if($i == 0) {
            $list[$i]['list_selected'] = 'y';
        }else{
            $list[$i]['list_selected'] = '';
        }
    }
}

echo json_encode($list);