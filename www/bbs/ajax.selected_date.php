<?php
include_once('./_common.php');

$this_date = $_POST['this_date'];
$spe_period = (int)$_POST['spe_period'];

$cnt = 1;
$num = 0;

$list = Array();

while($cnt < $spe_period) {
    $this_date = date("Y-m-d", strtotime($this_date."+1day"));
    $yoil = date('w', strtotime($this_date));
    if($yoil>0 && $yoil<6) {
        $holiday_sql = " select count(*) as cnt from g5_holiday where h_date = '{$this_date}' and is_holiday = 'Y' ";
        $holiday_row = sql_fetch($holiday_sql);
        if($holiday_row['cnt'] == 0) {
            $list['next_date'][$num] = $this_date;
            $cnt++;
            $num++;
        }

    }
}

echo json_encode($list);