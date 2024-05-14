<?php
include_once('./_common.php');

$this_year = $_POST['year'];
$this_month = $_POST['month'];

$year = $this_year;
$month = $this_month;

if(!$year) $year = date('Y');
if(!$month) $month = (int)date('m');

$month_val = $month;
if($month < 10) $month_val = '0'.$month;

$prev_year = $year;
$prev_month = $month - 1;
if($prev_month == 0) {
    $prev_year = $year - 1;
    $prev_month = 12;
}

$next_year = $year;
$next_month = $month + 1;
if($next_month == 13) {
    $next_year = $year + 1;
    $next_month = 1;
}

$time = strtotime($year.'-'.$month.'-01');
$today_time = strtotime(date('Y-m-d'));
list($tday, $sweek) = explode('-', date('t-w', $time));
$tweek = ceil(($tday + $sweek) / 7);
$lweek = date('w', strtotime($year.'-'.$month.'-'.$tday));

$list['sweek'] = $sweek;
$list['tweek'] = $tweek;
$list['lweek'] = $lweek;

$holiday_sql = " select * from g5_holiday where h_year = '{$year}' and h_month = '{$month}' and is_holiday = 'Y' ";
$holiday_qry = sql_query($holiday_sql);
$holiday_num = sql_num_rows($holiday_qry);
if($holiday_num > 0) {
    for($i=0; $holiday_row = sql_fetch_array($holiday_qry); $i++) {
        $list[$holiday_row['h_date']] = $holiday_row['h_name'];
    }
}

echo json_encode($list);
?>