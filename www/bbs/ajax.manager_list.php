<?php
include_once('./_common.php');

$sch_branch = '';
$sch_mb_name = '';
$mb_id = $_POST['mb_id'];

$sch_branch = $_POST['sch_branch'];
$sch_mb_name = $_POST['sch_mb_name'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and a.mb_level = 5 and a.mb_hide = ''";

// 지점 필터링
if($sch_branch != '') {
    $where_str .= " and a.branch_id = '{$sch_branch}'";
}

// 이름 필터링
if($sch_mb_name != '') {
    $where_str .= " and mb_name like '%{$sch_mb_name}%'";
}

// 아이디 값이 있을 경우 해당 아이디가 맨 위로 가도록 설정 | 아이디 값이 없을 경우 활동중 > 보류 > 휴직 > 퇴사 + 가나다 순
if($mb_id != '') {
    $orderby_str .= " a.mb_id = '{$mb_id}' desc, a.activity_status = '활동중' desc, a.activity_status = '보류' desc, a.activity_status = '휴직' desc, a.activity_status = '퇴사' desc, a.mb_name asc";
}else{
    $orderby_str .= " a.activity_status = '활동중' desc, a.activity_status = '보류' desc, a.activity_status = '휴직' desc, a.activity_status = '퇴사' desc, a.mb_name asc";
}

$sql = " select distinct(a.mb_id), a.* from g5_member as a left join g5_management as b on b.mb_id = a.mb_id where (1=1) {$where_str} order by {$orderby_str} ";
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

        if($mb_id != '' && $mb_id == $row['mb_id']) {
            $list[$i]['list_selected'] = 'y';
        }else{
            if($mb_id == '' && $i == 0) {
                $list[$i]['list_selected'] = 'y';
            }else{
                $list[$i]['list_selected'] = '';
            }
        }
    }
}

echo json_encode($list);