<?php
include_once('./_common.php');

$client_idx = $_POST['client_idx'];
$client_service = $_POST['client_service'];
$date_selected = $_POST['date_selected'];
$first_date_selected = $date_selected[0];
$str_hour = $_POST['str_hour'];
$end_hour = $_POST['end_hour'];

$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);

// 아가마지 합계금액
function client_service_baby() {
    global $client_idx, $client_service, $date_selected, $first_date_selected, $client_row;

    // 첫날 년도
    $spp_year = substr($first_date_selected, 0, 4);
    $spp_sql = " select * from g5_service_period_price as a left join g5_service_period as b on b.spe_id = a.spe_id where a.spe_id = '{$client_row['cl_service_period']}' and a.spp_year = '{$spp_year}' and a.branch_id = '{$client_row['branch_id']}' and b.spe_use = '1' ";
    $spp_row = sql_fetch($spp_sql);
    // 서비스 금액
    $period_price = $spp_row['spp_deductible'];
    if($period_price == '' || $period_price == 0) {
        return false;
    }

    $opp_sql = " select * from g5_service_option_price as a left join g5_service_option as b on b.sop_id = a.sop_id where a.sop_id = '{$client_row['cl_service_option']}' and a.spp_year = '{$spp_year}' and a.branch_id = '{$client_row['branch_id']}' and b.sop_use = '1' ";
    $opp_row = sql_fetch($opp_sql);
    // 옵션 금액
    if($opp_row['spp_id'] != '') {
        $option_price = (int)$spp_row['spe_period'] * (int)$opp_row['spp_price'];
    }

    $school_sql = " select * from g5_service_option as a left join g5_service_option_price as b on b.sop_id = a.sop_id where a.client_service = '{$client_service}' and a.sop_cate = 'school' and a.sop_use = '1' and b.spp_year = '{$spp_year}' and b.branch_id = '{$client_row['branch_id']}' ";
    $school_row = sql_fetch($school_sql);
    // 취학 금액
    if($school_row['spp_id'] != '') {
        $school_price = (int)$spp_row['spe_period'] * ((int)$client_row['cl_school'] * (int)$school_row['spp_price']);
    }

    $preschool_sql = " select * from g5_service_option as a left join g5_service_option_price as b on b.sop_id = a.sop_id where a.client_service = '{$client_service}' and a.sop_cate = 'preschool' and a.sop_use = '1' and b.spp_year = '{$spp_year}' and b.branch_id = '{$client_row['branch_id']}' ";
    $preschool_row = sql_fetch($preschool_sql);
    // 미취학 금액
    if($preschool_row['spp_id'] != '') {
        $preschool_price = (int)$spp_row['spe_period'] * ((int)$client_row['cl_preschool'] * (int)$preschool_row['spp_price']);
    }

    $tot_price = (int)$period_price + (int)$option_price + (int)$school_price + (int)$preschool_price;

    $list = number_format($tot_price);

    return $list;
}

// 베이비시터 합계금액
function client_service_babysitter() {
    global $client_idx, $client_service, $date_selected, $first_date_selected, $str_hour, $end_hour, $client_row;

    // 첫날 년도
    $spp_year = substr($first_date_selected, 0, 4);
    $spp_sql = " select * from g5_service_period_price as a left join g5_service_period as b on b.spe_id = a.spe_id where a.spe_id = '{$client_row['cl_service_period']}' and a.spp_year = '{$spp_year}' and a.branch_id = '{$client_row['branch_id']}' and b.spe_use = '1' ";
    $spp_row = sql_fetch($spp_sql);
    // 서비스 금액
    $period_price = 0;
    if($period_price == '' || $period_price == 0) {
        return false;
    }

    $period_sql = " select * from g5_service_period where client_service = '{$client_service}' and spe_id = '{$client_row['cl_service_period']}' and spe_use = '1' ";
    $period_row = sql_fetch($period_sql);

    $add_sql = " select * from g5_service_option as a left join g5_service_option_price as b on b.sop_id = a.sop_id where a.client_service = '{$client_service}' and a.sop_cate = 'overtime' and a.sop_use = '1' and b.branch_id = '{$client_row['branch_id']}' and b.spp_year = '{$spp_year}' ";
    $add_row = sql_fetch($add_sql);
    // 연장근무 금액
    $add_price = 0;

    $twins_sql = " select * from g5_service_option as a left join g5_service_option_price as b on b.sop_id = a.sop_id where a.client_service = '{$client_service}' and a.sop_cate = 'surcharge' and a.sop_name = '쌍둥이' and a.sop_use = '1' and b.branch_id = '{$client_row['branch_id']}' and b.spp_year = '{$spp_year}' ";
    $twins_row = sql_fetch($twins_sql);
    // 쌍둥이 금액
    $twins_price = 0;

    $fbaby_sql = " select * from g5_service_option as a left join g5_service_option_price as b on b.sop_id = a.sop_id where a.client_service = '{$client_service}' and a.sop_cate = 'surcharge' and a.sop_name = '큰아이' and a.sop_use = '1' and b.branch_id = '{$client_row['branch_id']}' and b.spp_year = '{$spp_year}' ";
    $fbaby_row = sql_fetch($fbaby_sql);
    // 큰아이 금액
    $fbaby_price = 0;

    if(count($date_selected) > 0) {
        for($i=0; $i<count($date_selected); $i++) {
            $selected_period_hour = (int)$end_hour[$i] - (int)$str_hour[$i];

            // 주말, 공휴일 할증
            $percent = 1;
            $yoil = date('w', strtotime($date_selected[$i]));
            if($yoil == 0 || $yoil == 6) {
                $percent = 1.2;
            }else{
                $holiday_sql = " select count(*) as cnt from g5_holiday where h_date = '{$date_selected[$i]}' and is_holiday = 'Y' ";
                $holiday_row = sql_fetch($holiday_sql);
                if($holiday_row['cnt'] > 0) {
                    $percent = 1.2;
                }
            }

            // 서비스 금액
            $period_price += (int)$spp_row['spp_deductible'] * $percent;
            if($spp_row['spp_deductible'] == '' || $spp_row['spp_deductible'] == 0) {
                return false;
            }

            // 연장근무 금액
            if($period_row['spe_period_hour'] < $selected_period_hour) {
                $add_price += (((int)$selected_period_hour - (int)$period_row['spe_period_hour']) * (int)$add_row['spp_price']) * $percent;
            }

            // 쌍둥이 금액
            if($client_row['cl_twins'] == 'y') {
                $twins_price += ((int)$selected_period_hour * $twins_row['spp_price']) * $percent;
            }

            // 큰아이 금액
            if($client_row['cl_baby_first'] == 'y') {
                $fbaby_price += ((int)$selected_period_hour * $fbaby_row['spp_price']) * $percent;
            }
        }
    }

    $tot_price = (int)$period_price + (int)$add_price + (int)$twins_price + (int)$fbaby_price;

    $list = number_format($tot_price);

    return $list;
}

// 청소 합계금액
function client_service_cleaning() {
    global $client_idx, $client_service, $date_selected, $first_date_selected, $str_hour, $end_hour, $client_row;

    // 첫날 년도
    $spp_year = substr($first_date_selected, 0, 4);
    $spp_sql = " select * from g5_service_period_price as a left join g5_service_period as b on b.spe_id = a.spe_id where a.spe_id = '{$client_row['cl_service_period']}' and a.spp_year = '{$spp_year}' and a.branch_id = '{$client_row['branch_id']}' and b.spe_use = '1' ";
    $spp_row = sql_fetch($spp_sql);
    // 서비스 금액
    $period_price = 0;
    if($period_price == '' || $period_price == 0) {
        return false;
    }

    $period_sql = " select * from g5_service_period where client_service = '{$client_service}' and spe_id = '{$client_row['cl_service_period']}' and spe_use = '1' ";
    $period_row = sql_fetch($period_sql);

    $add_sql = " select * from g5_service_option as a left join g5_service_option_price as b on b.sop_id = a.sop_id where a.client_service = '{$client_service}' and a.sop_cate = 'overtime' and a.sop_use = '1' and b.branch_id = '{$client_row['branch_id']}' and b.spp_year = '{$spp_year}' ";
    $add_row = sql_fetch($add_sql);
    // 연장근무 금액
    $add_price = 0;

    $opp_sql = " select * from g5_service_option_price as a left join g5_service_option as b on b.sop_id = a.sop_id where a.sop_id = '{$client_row['cl_service_option']}' and a.spp_year = '{$spp_year}' and a.branch_id = '{$client_row['branch_id']}' and b.sop_use = '1' ";
    $opp_row = sql_fetch($opp_sql);
    // 옵션 금액
    if($opp_row['spp_id'] != '') {
        $option_price = 0;
    }

    if(count($date_selected) > 0) {
        for($i=0; $i<count($date_selected); $i++) {
            $selected_period_hour = (int)$end_hour[$i] - (int)$str_hour[$i];

            // 주말, 공휴일 할증
            $percent = 1;
            $yoil = date('w', strtotime($date_selected[$i]));
            if($yoil == 0 || $yoil == 6) {
                $percent = 1.2;
            }else{
                $holiday_sql = " select count(*) as cnt from g5_holiday where h_date = '{$date_selected[$i]}' and is_holiday = 'Y' ";
                $holiday_row = sql_fetch($holiday_sql);
                if($holiday_row['cnt'] > 0) {
                    $percent = 1.2;
                }
            }

            // 서비스 금액
            $period_price += (int)$spp_row['spp_deductible'] * $percent;
            if($spp_row['spp_deductible'] == '' || $spp_row['spp_deductible'] == 0) {
                return false;
            }

            // 연장근무 금액
            if($period_row['spe_period_hour'] < $selected_period_hour) {
                $add_price += (((int)$selected_period_hour - (int)$period_row['spe_period_hour']) * (int)$add_row['spp_price']) * $percent;
            }

            // 옵션 금액
            $option_price += (int)$opp_row['spp_price'] * $percent;
        }
    }

    $tot_price = (int)$period_price + (int)$add_price + (int)$option_price;

    $list = number_format($tot_price);

    return $list;
}

// 반찬 합계금액
function client_service_dish() {
    global $client_idx, $client_service, $date_selected, $first_date_selected, $str_hour, $end_hour, $client_row;

    // 첫날 년도
    $spp_year = substr($first_date_selected, 0, 4);
    $spp_sql = " select * from g5_service_period_price as a left join g5_service_period as b on b.spe_id = a.spe_id where a.spe_id = '{$client_row['cl_service_period']}' and a.spp_year = '{$spp_year}' and a.branch_id = '{$client_row['branch_id']}' and b.spe_use = '1' ";
    $spp_row = sql_fetch($spp_sql);
    // 서비스 금액
    $period_price = 0;
    if($period_price == '' || $period_price == 0) {
        return false;
    }

    $period_sql = " select * from g5_service_period where client_service = '{$client_service}' and spe_id = '{$client_row['cl_service_period']}' and spe_use = '1' ";
    $period_row = sql_fetch($period_sql);

    if(count($date_selected) > 0) {
        for($i=0; $i<count($date_selected); $i++) {
            $selected_period_hour = (int)$end_hour[$i] - (int)$str_hour[$i];

            // 주말, 공휴일 할증
            $percent = 1;
            $yoil = date('w', strtotime($date_selected[$i]));
            if($yoil == 0 || $yoil == 6) {
                $percent = 1.2;
            }else{
                $holiday_sql = " select count(*) as cnt from g5_holiday where h_date = '{$date_selected[$i]}' and is_holiday = 'Y' ";
                $holiday_row = sql_fetch($holiday_sql);
                if($holiday_row['cnt'] > 0) {
                    $percent = 1.2;
                }
            }

            // 서비스 금액
            $period_price += (int)$spp_row['spp_deductible'] * $percent;
            if($spp_row['spp_deductible'] == '' || $spp_row['spp_deductible'] == 0) {
                return false;
            }
        }
    }

    $tot_price = (int)$period_price + (int)$add_price + (int)$option_price;

    $list = number_format($tot_price);

    return $list;
}

$list = Array();
$list['tot_price'] = 0;

if($client_service == '아가마지') {
    $list['tot_price'] = client_service_baby();
}else if($client_service == '베이비시터') {
    $list['tot_price'] = client_service_babysitter();
}else if($client_service == '청소') {
    $list['tot_price'] = client_service_cleaning();
}else if($client_service == '반찬') {
    $list['tot_price'] = client_service_dish();
}

echo json_encode($list);