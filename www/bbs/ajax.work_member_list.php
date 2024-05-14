<?php
include_once('./_common.php');

$area_x = $_POST['area_x'];
$area_y = $_POST['area_y'];
$client_service = $_POST['client_service'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and mb_level = 2 and mb_hide = '' and activity_status = '활동중' and service_category = '{$client_service}'";

if($area_x != '' && $area_y != '') {
    $orderby_str .= ", activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

    $sql = " select *, 
    ( 6371 * acos( cos( radians( $area_y ) ) * cos( radians( mb_area_y ) ) * cos( radians( mb_area_x ) - radians( $area_x ) ) + sin( radians( $area_y ) ) * sin( radians( mb_area_y ) ) ) ) AS distance
    from g5_member where (1=1) {$where_str} 
    HAVING distance < 100 
    order by distance asc {$orderby_str} ";
}else{
    $orderby_str .= "activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

    $sql = " select * from g5_member where (1=1) {$where_str} order by {$orderby_str} ";
}
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