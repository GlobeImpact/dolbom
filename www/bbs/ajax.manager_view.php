<?php
include_once('./_common.php');

$mb_id = $_POST['mb_id'];

$list = Array();

$sql = " select * from g5_member where (1=1) and mb_level = 5 and mb_hide = '' and mb_id = '{$mb_id}' ";
$row = sql_fetch($sql);

$branch_sql = " select * from g5_branch where branch_id = '{$row['branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

$list['v_branch_id'] = $branch_row['branch_name'];
$list['v_mb_name'] = $row['mb_name'];
if($row['security_number'] != '') {
    $list['v_mb_name'] .= ' (';
    $list['v_mb_name'] .= wz_get_gender($row['security_number']).'자';
    $list['v_mb_name'] .= '·'.wz_get_age($row['security_number']);
    $list['v_mb_name'] .= ')';
}
$list['v_mb_hp'] = $row['mb_hp'];
$list['v_activity_status'] = $row['activity_status'];
$list['v_id'] = $row['mb_id'];
$list['v_security_number'] = $row['security_number'];
$list['v_enter_date'] = '';
if($row['enter_date'] != '0000-00-00') $list['v_enter_date'] = $row['enter_date'];
$list['v_quit_date'] = '';
if($row['quit_date'] != '0000-00-00') $list['v_quit_date'] = $row['quit_date'];
$list['v_addr'] = '';
if($row['mb_zip1'] != '' || $row['mb_zip2'] != '') $list['v_addr'] .= '['.$row['mb_zip1'].$row['mb_zip2'].']';
if($row['mb_addr1'] != '') $list['v_addr'] .= ' '.$row['mb_addr1'];
if($row['mb_addr2'] != '') $list['v_addr'] .= ' '.$row['mb_addr2'];
$list['v_mb_memo'] = nl2br($row['mb_memo']);

$orderby_str = "me_code asc";

foreach($set_management_mode_arr as $key => $value) {
    $orderby_str .= ", mode = '{$key}' desc";
}

$me_code1_sql = " select distinct(a.me_code1), b.me_name from g5_management as a left join g5_menu as b on b.me_code = a.me_code1 where a.mb_id = '{$mb_id}' ";
$me_code1_qry = sql_query($me_code1_sql);
$me_code1_num = sql_num_rows($me_code1_qry);
if($me_code1_num > 0) {
    for($i=0; $me_code1_row = sql_fetch_array($me_code1_qry); $i++) {
        $list['me_code1'][$i]['me_code'] = $me_code1_row['me_code1'];
        $list['me_code1'][$i]['me_name'] = $me_code1_row['me_name'];

        $me_code2_sql = " select distinct(a.me_code2), b.me_name from g5_management as a left join g5_menu as b on b.me_code = a.me_code2 where a.mb_id = '{$mb_id}' and a.me_code1 = '{$me_code1_row['me_code1']}' ";
        $me_code2_qry = sql_query($me_code2_sql);
        $me_code2_num = sql_num_rows($me_code2_qry);
        if($me_code2_num > 0) {
            for($j=0; $me_code2_row = sql_fetch_array($me_code2_qry); $j++) {
                $list['me_code2'][$me_code1_row['me_code1']][$j]['me_code'] = $me_code2_row['me_code2'];
                $list['me_code2'][$me_code1_row['me_code1']][$j]['me_name'] = $me_code2_row['me_name'];

                $me_code3_sql = " select distinct(a.me_code3), b.me_name from g5_management as a left join g5_menu as b on b.me_code = a.me_code3 where a.mb_id = '{$mb_id}' and a.me_code2 = '{$me_code2_row['me_code2']}' ";
                $me_code3_qry = sql_query($me_code3_sql);
                $me_code3_num = sql_num_rows($me_code3_qry);
                if($me_code3_num > 0) {
                    for($k=0; $me_code3_row = sql_fetch_array($me_code3_qry); $k++) {
                        $list['me_code3'][$me_code2_row['me_code2']][$k]['me_code'] = $me_code3_row['me_code3'];
                        $list['me_code3'][$me_code2_row['me_code2']][$k]['me_name'] = $me_code3_row['me_name'];

                        foreach($set_management_mode_arr as $key => $value) {
                            $management_sql = " select count(*) as cnt from g5_management where mb_id = '{$mb_id}' and me_code = '{$me_code3_row['me_code3']}' and mode = '{$key}' ";
                            $management_row = sql_fetch($management_sql);
                            if($management_row['cnt'] > 0) {
                                $list['management'][$me_code3_row['me_code3']][$key] = $value;
                            }else{
                                $list['management'][$me_code3_row['me_code3']][$key] = '';
                            }
                        }
                    }
                }else{
                    $list['me_code3'][$me_code2_row['me_code2']] = '';
                }
            }
        }else{
            $list['me_code2'][$me_code1_row['me_code1']] = '';
        }
    }
}else{
    $list['me_code1'] = '';
}

echo json_encode($list);