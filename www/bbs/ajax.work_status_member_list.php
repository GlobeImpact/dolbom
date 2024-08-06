<?php
include_once('./_common.php');

$sch_str_selected_date = $_POST['sch_str_selected_date'];
$sch_end_selected_date = $_POST['sch_end_selected_date'];

$list = Array();

$where_str = "";
$orderby_str = "";

if($sch_str_selected_date != '' && $sch_end_selected_date != '') {
    $where_str .= " and (b.selected_date >= '{$sch_str_selected_date}' and b.selected_date <= '{$sch_end_selected_date}')";
}else if($sch_str_selected_date != '') {
    $where_str .= " and (b.selected_date >= '{$sch_str_selected_date}')";
}else if($sch_end_selected_date != '') {
    $where_str .= " and (b.selected_date <= '{$sch_end_selected_date}')";
}

$orderby_str .= "a.activity_status = '활동중' desc, a.activity_status = '보류' desc, a.activity_status = '휴직' desc, a.activity_status = '퇴사' desc, a.mb_name asc";

$sql = " select distinct a.mb_id, a.* from g5_member as a left join g5_work_selected as b on b.mb_id = a.mb_id where a.mb_menu = '{$_SESSION['this_code']}' and a.branch_id = '{$_SESSION['this_branch_id']}' and a.mb_level = 2 and a.mb_hide = '' and a.activity_status = '활동중' {$where_str} order by {$orderby_str} ";

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
        // 팀
        $list[$i]['team_category'] = $row['team_category'];
        // 연락처
        $list[$i]['mb_hp'] = $row['mb_hp'];
        // 성별
        $list[$i]['gender'] = '';
        if($row['security_number'] != '') $list[$i]['gender'] = wz_get_gender($row['security_number']).'자';
        // 생년월일
        $list[$i]['birthday'] = '';
        if($row['security_number'] != '') $list[$i]['birthday'] = wz_get_birth($row['security_number']);
        // 입사일자
        $list[$i]['enter_date'] = '';
        if($row['enter_date'] != '0000-00-00') $list[$i]['enter_date'] = $row['enter_date'];
        // 행정구역
        $mb_addr_arr = explode(' ', $row['mb_addr1']);
        $list[$i]['mb_addr'] = '';
        if($row['mb_addr1'] != '') $list[$i]['mb_addr'] = $mb_addr_arr[1];
        // 특이사항
        $list[$i]['mb_memo2'] = $row['mb_memo2'];
        // 거리
        $list[$i]['area'] = round($row['distance'], 1);

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