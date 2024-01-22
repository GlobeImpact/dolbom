<?php
include_once('./_common.php');

$now_year = '';
$sch_value = '';

$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];

$list = Array();

$where_str = "";
$orderby_str = "";

if($sch_value != '') {
    $where_str .= " and edu_tit like '%{$sch_value}%'";
}

$orderby_str .= " edu_date desc, edu_str_hour desc, edu_tit asc";

$set_sql = " select * from g5_member_education_set where set_hide = '' order by set_idx asc ";
$set_qry = sql_query($set_sql);
$set_num = sql_num_rows($set_qry);

if($set_num > 0) {
    for($i=0; $set_row = sql_fetch_array($set_qry); $i++) {
        $sql = " select * from g5_member_education where set_mb_menu = '{$_SESSION['this_code']}' and set_idx = '{$set_row['set_idx']}' and edu_year = '{$now_year}' {$where_str} order by {$orderby_str} ";
        $qry = sql_query($sql);
        $num = sql_num_rows($qry);

        if($num > 0) {
            for($j=0; $row = sql_fetch_array($qry); $j++) {
                $mb_sql = " select count(*) as cnt from g5_member where (1=1) and mb_menu = '{$_SESSION['this_code']}' and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') ";
                $mb_row = sql_fetch($mb_sql);
                $max_list = (int)$mb_row['cnt'];
                
                $edul_sql = " select count(*) as cnt from g5_member_education_list where edu_idx = '{$row['edu_idx']}' ";
                $edul_row = sql_fetch($edul_sql);
                $edu_list = (int)$edul_row['cnt'];

                $not_list = $max_list - $edu_list;

                if($j == 0) {
                    $list[$i][$j]['set_idx'] = $set_row['set_idx'];
                    $list[$i][$j]['set_tit'] = $set_row['set_tit'];
                }

                $numb = $num - $j;

                $list[$i][$j]['numb'] = $numb;
                $list[$i][$j]['edu_idx'] = $row['edu_idx'];
                $list[$i][$j]['edu_date'] = $row['edu_date'];
                $list[$i][$j]['edu_tit'] = $row['edu_tit'];
                $list[$i][$j]['max_list'] = $max_list;
                $list[$i][$j]['edu_list'] = $edu_list;
                $list[$i][$j]['not_list'] = $not_list;
            }
        }else{
            $list[$i][0]['set_idx'] = '';
            $list[$i][0]['set_tit'] = $set_row['set_tit'];
        }
    }
}

echo json_encode($list);