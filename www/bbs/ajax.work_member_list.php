<?php
include_once('./_common.php');

$area_x = $_POST['area_x'];
$area_y = $_POST['area_y'];
$client_idx = $_POST['client_idx'];
$client_service = $_POST['client_service'];

$list = Array();

// 고객정보 불러오기
$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);
$work_selected_where_str = "";
if( ($client_row['str_date'] != '' && $client_row['str_date'] != '0000-00-00') && ($client_row['end_date'] != '' && $client_row['end_date'] != '0000-00-00') ) {
    $work_selected_where_str .= " and a.selected_date >= '{$client_row['str_date']}' and a.selected_date <= '{$client_row['end_date']}'";
}else if($client_row['str_date'] != '' && $client_row['str_date'] != '0000-00-00') {
    $work_selected_where_str .= " and a.selected_date >= '{$client_row['str_date']}' ";
}else if($client_row['end_date'] != '' && $client_row['end_date'] != '0000-00-00') {
    $work_selected_where_str .= " and a.selected_date >= '".date('Y-m-d')."' and a.selected_date <= '{$client_row['end_date']}'";
}

$where_str = "";
$orderby_str = "";

$where_str .= " and a.mb_menu = '{$_SESSION['this_code']}' and a.branch_id = '{$_SESSION['this_branch_id']}' and a.mb_level = 2 and a.mb_hide = '' and a.activity_status = '활동중' and a.service_category = '{$client_service}'";

if($area_x != '' && $area_y != '') {
    $orderby_str .= ", a.activity_status = '활동중' desc, a.activity_status = '보류' desc, a.activity_status = '휴직' desc, a.activity_status = '퇴사' desc, a.mb_name asc";

    $sql = " select a.*, 
    ( 6371 * acos( cos( radians( $area_y ) ) * cos( radians( a.mb_area_y ) ) * cos( radians( a.mb_area_x ) - radians( $area_x ) ) + sin( radians( $area_y ) ) * sin( radians( a.mb_area_y ) ) ) ) AS distance
    from g5_member as a where (1=1) {$where_str} 
    HAVING distance < 100 
    order by distance asc {$orderby_str} ";
}else{
    $orderby_str .= "a.activity_status = '활동중' desc, a.activity_status = '보류' desc, a.activity_status = '휴직' desc, a.activity_status = '퇴사' desc, a.mb_name asc";

    $sql = " select * from g5_member as a where (1=1) {$where_str} order by {$orderby_str} ";
}
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['work_stat'] = '';
        $work_sql = "";
        if($work_selected_where_str != '') {
            $work_sql = " select count(*) as cnt from g5_work_selected as a left join g5_work as b on b.idx = a.work_idx where a.mb_id = '{$row['mb_id']}' and b.status != '취소' {$work_selected_where_str} ";
            $list[$i]['work_sql'] = $work_sql;
            $work_row = sql_fetch($work_sql);
            if($work_row['cnt'] > 0) $list[$i]['work_stat'] = '파견';
        }

        // 회원 Index
        $list[$i]['mb_no'] = $row['mb_no'];
        // 회원 아이디
        $list[$i]['mb_id'] = $row['mb_id'];
        // 현황
        $list[$i]['activity_status'] = $row['activity_status'];
        // 직원명
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