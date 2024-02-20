<?php
include_once('./_common.php');

$idx = $_POST['idx'];
if($idx == '0') $idx = '';
$sch_value2 = $_POST['sch_value2'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and mb_level = 2 and mb_hide = ''";

if($sch_value2 != '') {
    $where_str .= " and mb_name like '%{$sch_value2}%'";
}

// 우선순위 : 활동중 > 보류 > 휴직 > 퇴사 + 가나다 순
$orderby_str .= " activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

$sql = " select * from g5_member where (1=1) and activity_status = '활동중' {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        // 회원 Index
        $list[$i]['mb_no'] = $row['mb_no'];
        // 회원 아이디
        $list[$i]['mb_id'] = $row['mb_id'];
        // 현황
        $list[$i]['activity_status'] = $row['activity_status'];
        // 매니저명
        $list[$i]['mb_name'] = $row['mb_name'];
        // 성별
        $list[$i]['gender'] = '';
        if($row['security_number'] != '') $list[$i]['gender'] = wz_get_gender($row['security_number']).'자';
        // 생년월일
        $list[$i]['birthday'] = '';
        if($row['security_number'] != '') $list[$i]['birthday'] = wz_get_birth($row['security_number']);
        // 입사일자
        $list[$i]['enter_date'] = '';
        if($row['enter_date'] != '0000-00-00') $list[$i]['enter_date'] = $row['enter_date'];
        // 서비스
        $list[$i]['service_category'] = $row['service_category'];

        $edul_sql = " select count(*) as cnt from g5_member_education_list where idx = '{$idx}' and edul_mb_id = '{$row['mb_id']}' ";
        $edul_row = sql_fetch($edul_sql);

        if($edul_row['cnt'] > 0) {
            $list[$i]['list_selected'] = 'y';
        }else{
            $list[$i]['list_selected'] = '';
        }
    }
}

echo json_encode($list);