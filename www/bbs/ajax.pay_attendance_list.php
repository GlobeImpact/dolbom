<?php
include_once('./_common.php');

$mb_id = '';

$mb_id = $_POST['mb_id'];

$first_date = $now_year.'-'.$now_month.'-01';
$last_date = $now_year.'-'.$now_month.'-31';

$list = Array();

$sql = " select a.idx as work_selected_idx2, a.selected_date, a.str_hour, a.end_hour, b.* from g5_work_selected as a left join g5_pay_attendance as b on b.mb_id = a.mb_id where a.mb_id = '{$mb_id}' order by a.selected_date asc ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['idx'] = $row['idx'];
        $list[$i]['work_selected_idx'] = $row['work_selected_idx'];
        if($row['work_selected_idx'] == '') $list[$i]['work_selected_idx'] = $row['work_selected_idx2'];
        $list[$i]['selected_date'] = $row['selected_date'];
        $selected_date_arr = explode('-', $row['selected_date']);
        $list[$i]['selected_year'] = $selected_date_arr[0];
        $list[$i]['selected_month'] = $selected_date_arr[1];
        $list[$i]['selected_day'] = $selected_date_arr[2];
        $list[$i]['str_hour'] = $row['str_hour'];
        $list[$i]['end_hour'] = $row['end_hour'];
        $list[$i]['at_work'] = ($row['at_work'] == null)?'':$row['at_work'];
        $list[$i]['at_payments'] = ($row['at_payments'] == null)?'':$row['at_payments'];
        $list[$i]['at_weekday'] = ($row['at_weekday'] == null)?'':$row['at_weekday'];
        $list[$i]['at_voucher'] = ($row['at_voucher'] == null)?'':$row['at_voucher'];
        $list[$i]['at_paid'] = ($row['at_paid'] == null)?'':$row['at_paid'];
        $list[$i]['at_twins'] = ($row['at_twins'] == null)?'':$row['at_twins'];
        $list[$i]['at_move_in'] = ($row['at_move_in'] == null)?'':$row['at_move_in'];
        $list[$i]['at_baby_first'] = ($row['at_baby_first'] == null)?'':$row['at_baby_first'];
        $list[$i]['at_massage'] = ($row['at_massage'] == null)?'':$row['at_massage'];
        $list[$i]['at_weekly_holiday'] = ($row['at_weekly_holiday'] == null)?'':$row['at_weekly_holiday'];
        $list[$i]['at_annual'] = ($row['at_annual'] == null)?'':$row['at_annual'];
        $list[$i]['at_premium'] = ($row['at_premium'] == null)?'':$row['at_premium'];
        $list[$i]['at_paid_sat'] = ($row['at_paid_sat'] == null)?'':$row['at_paid_sat'];
        $list[$i]['at_voucher_sat'] = ($row['at_voucher_sat'] == null)?'':$row['at_voucher_sat'];
        $list[$i]['at_disabled'] = ($row['at_disabled'] == null)?'':$row['at_disabled'];
        $list[$i]['at_holiday'] = ($row['at_holiday'] == null)?'':$row['at_holiday'];
        $list[$i]['at_days'] = ($row['at_days'] == null)?'':$row['at_days'];
        $list[$i]['at_hours'] = ($row['at_hours'] == null)?'':$row['at_hours'];
        $list[$i]['at_work_number'] = ($row['at_work_number'] == null)?'':$row['at_work_number'];
        $list[$i]['at_yoil'] = get_yoil($row['selected_date']);
    }
}

echo json_encode($list);