<?php
include_once('./_common.php');

$sch_activity_status = '';
$sch_service_category = '';
$sch_mb_name = '';
$mb_id = $_POST['mb_id'];
$now_year = '';
$now_month = '';
$sort_orderby = '';

$sch_activity_status = $_POST['sch_activity_status'];
$sch_service_category = $_POST['sch_service_category'];
$sch_mb_name = $_POST['sch_mb_name'];
$now_year = ($_POST['now_year'] != '') ? $_POST['now_year'] : '';
$now_month = ($_POST['now_month'] != '') ? $_POST['now_month'] : '';
$sort_orderby = $_POST['sort_orderby'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and mb_level = 2 and mb_hide = ''";

// 활동현황 필터링
if($sch_activity_status != '') {
    $where_str .= " and activity_status = '{$sch_activity_status}'";
}

// 서비스구분 필터링
if($sch_service_category != '') {
    $where_str .= " and service_category = '{$sch_service_category}'";
}

// 이름 필터링
if($sch_mb_name != '') {
    $where_str .= " and mb_name like '%{$sch_mb_name}%'";
}

// 아이디 값이 있을 경우 해당 아이디가 맨 위로 가도록 설정 | 아이디 값이 없을 경우 활동중 > 보류 > 휴직 > 퇴사 + 가나다 순
if($mb_id != '') {
    $orderby_str .= " mb_id = '{$mb_id}' desc, activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc {$sort_orderby}";
}else{
    $orderby_str .= " activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc {$sort_orderby}";
}

$sql = " select * from g5_member where (1=1) {$where_str} order by {$orderby_str} ";
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
        $list[$i]['mb_name'] = ($row['mb_name'] != '')?$row['mb_name']:'';
        // 매니저명
        $list[$i]['v_mb_name'] = ($row['mb_name'] != '')?$row['mb_name']:'';
        // 프리미엄
        $list[$i]['premium_use'] = $row['premium_use'];
        $list[$i]['v_premium_use'] = ($row['premium_use'] != '')?$row['premium_use']:'';
        // 팀
        $list[$i]['team_category'] = $row['team_category'];
        // 연락처
        $list[$i]['mb_hp'] = $row['mb_hp'];
        // 반려동물
        $list[$i]['pet_use'] = $row['pet_use'];
        // 주소
        $list[$i]['mb_addr1'] = $row['mb_addr1'];
        // 취약계층
        $list[$i]['vulnerable'] = '';
        if($row['vulnerable'] != '') {
            if($row['vulnerable'] == '기타') {
                $list[$i]['vulnerable'] .= $row['vulnerable_etc'];
            }else{
                $list[$i]['vulnerable'] .= $row['vulnerable'];
            }
        }
        // 성별
        $list[$i]['gender'] = '';
        if($row['security_number'] != '') $list[$i]['gender'] = wz_get_gender($row['security_number']).'자';
        // 생년월일
        $list[$i]['birthday'] = '';
        if($row['security_number'] != '') $list[$i]['birthday'] = wz_get_birth($row['security_number']);
        // 학력
        $list[$i]['education_memo'] = $row['education_memo'];
        // 경력
        $list[$i]['career_memo'] = $row['career_memo'];
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

        // 파견수
        $list[$i]['work_cnt'] = 0;
        if($now_year != '' && $now_month != '') {
            $first_date = $now_year.'-'.$now_month.'-01';
            $last_date = $now_year.'-'.$now_month.'-31';
            // $work_sql = " select count(*) as cnt from g5_work_selected as a left join g5_member as b on b.mb_id = a.mb_id where a.mb_id = '{$row['mb_id']}' and selected_date >= '{$first_date}' and selected_date <= '{$last_date}' ";
            $work_sql = " select count(*) as cnt from g5_work_selected as a left join g5_member as b on b.mb_id = a.mb_id where a.mb_id = '{$row['mb_id']}' ";
            $work_row = sql_fetch($work_sql);
            $list[$i]['work_cnt'] = $work_row['cnt'];
        }
    }
}

echo json_encode($list);