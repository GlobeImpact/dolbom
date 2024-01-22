<?php
include_once('./_common.php');

// 주민번호로 성별 계산
function wz_get_gender($ymd = '') {
    if (!$ymd || empty($ymd)) { 
        return false;
    }

    $gender = '';
    switch (substr(trim($ymd),7,1)) {
        case '1':
        case '3':
        case '5':
        case '7':
            $gender = '남';
        break;
        case '2':
        case '4':
        case '6':
        case '8':
            $gender = '여';
        break;
    }

    return $gender;
}

$set_idx = '';
$now_year = '';
$sch_value = '';

$set_idx = $_POST['set_idx'];
$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}'";

if($sch_value != '') {
    $where_str .= " and mb_name like '%{$sch_value}%'";
}

$orderby_str .= " activity_status = '보류' desc, activity_status = '활동중' desc, mb_name asc";

$sql = " select * from g5_member where (1=1) and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['mb_no'] = $row['mb_no'];
        $list[$i]['mb_id'] = $row['mb_id'];
        $list[$i]['activity_status'] = $row['activity_status'];
        $list[$i]['mb_name'] = $row['mb_name'];
        $list[$i]['service_category'] = $row['service_category'];
        $list[$i]['team_category'] = $row['team_category'];
        $list[$i]['security_number'] = substr($row['security_number'], 0, 8);
        $list[$i]['enter_date'] = $row['enter_date'];
        $list[$i]['quit_date'] = $row['quit_date'];
        $list[$i]['contract_type'] = $row['contract_type'];

        $gender = wz_get_gender($row['security_number']);
        $list[$i]['gender'] = $gender;

        if($row['enter_date'] == '0000-00-00') $list[$i]['enter_date'] = '';
        if($row['quit_date'] == '0000-00-00') $list[$i]['quit_date'] = '';

        if($set_idx != '') $set_where_str = " and set_idx = '{$set_idx}'";
        $set_sql = " select * from g5_member_health_set where (1=1) {$set_where_str} order by set_idx asc ";
        $set_qry = sql_query($set_sql);
        $set_num = sql_num_rows($set_qry);
        if($set_num > 0) {
            $list[$i]['set_count'] = $set_num;
            for($j=0; $set_row = sql_fetch_array($set_qry); $j++) {
                $list[$i]['health'][$j]['set_idx'] = $set_row['set_idx'];
                $list[$i]['health'][$j]['set_tit'] = $set_row['set_tit'];

                $heal_sql = " select * from g5_member_health where set_idx = '{$set_row['set_idx']}' and heal_year = '{$now_year}' and heal_mb_id = '{$row['mb_id']}' ";
                $heal_row = sql_fetch($heal_sql);
                if($heal_row['heal_idx'] != '') {
                    $list[$i]['health'][$j]['heal_idx'] = $heal_row['heal_idx'];
                    $list[$i]['health'][$j]['heal_date'] = $heal_row['heal_date'];
                }else{
                    $list[$i]['health'][$j]['heal_idx'] = '';
                    $list[$i]['health'][$j]['heal_date'] = '미작성';
                }
            }
        }else{
            $list[$i]['set_count'] = 0;
        }
    }
}

echo json_encode($list);