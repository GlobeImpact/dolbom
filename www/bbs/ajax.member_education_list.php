<?php
include_once('./_common.php');

$now_year = '';
$sch_value = '';
$set_idx = '';
$idx = '';

$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];
$set_idx = $_POST['set_idx'];
$idx = $_POST['idx'];

$list = Array();

$set_sql = " select * from g5_member_education_set where set_idx = '{$set_idx}' and set_hide = '' ";
$set_row = sql_fetch($set_sql);

if($idx != '') $where_str = " and idx = '{$idx}'";
$sql = " select * from g5_member_education where set_branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}' and set_idx = '{$set_idx}' and edu_year = '{$now_year}' {$where_str} order by edu_date desc, edu_str_hour desc, edu_tit asc ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

/* List Table HD 추출 STR */
$menu_cell = '';
$cell_width_tot = 725.88;
$cell_width = $cell_width_tot / $num;

$list['cell_count'] = $num;
$list['cell_width'] = $cell_width;

switch ($idx) {
    case '':
        if($num > 0) {
            for($m=0; $row = sql_fetch_array($qry); $m++) {
                $menu_cell .= '<th style="width:'.$cell_width.'px;">'.$row['edu_tit'].'</th>';
            }
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb" rowspan="2">번호</th>
            <th class="layer_list_activity_status" rowspan="2">현황</th>
            <th class="layer_list_name" rowspan="2">직원명</th>
            <th class="layer_list_date" rowspan="2">생년월일</th>
            <th class="layer_list_date" rowspan="2">입사일자</th>
            <th colspan="'.$num.'">'.$set_row['set_tit'].'</th>
        </tr>
        <tr>'.$menu_cell.'</tr>
        ';
    break;

    default:
        $menu_cell = '';

        if($num > 0) {
            $row = sql_fetch_array($qry);
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb">번호</th>
            <th class="layer_list_activity_status">현황</th>
            <th class="layer_list_name">직원명</th>
            <th class="layer_list_date">생년월일</th>
            <th class="layer_list_date">입사일자</th>
            <th class="layer_list_tel">연락처</th>
            <th class="layer_list_service_category">서비스</th>
            <th class="layer_list_status">계약형태</th>
            <th class="layer_list_numb">팀</th>
            <th>'.$row['edu_tit'].'</th>
        </tr>
        ';
    break;
}
/* List Table HD 추출 END */

/* 회원 리스트 불러오기 STR */
$mb_where_str = "";
$mb_orderby_str = "";

if($sch_value != '') {
    $mb_where_str .= " and mb_name like '%{$sch_value}%'";
}

$mb_orderby_str .= " activity_status = '활동중' desc, activity_status = '보류' desc, mb_name asc";

$sql = " select * from g5_member where branch_id = '{$_SESSION['this_branch_id']}' and mb_menu = '{$_SESSION['this_code']}' and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') {$mb_where_str} order by {$mb_orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        // 회원 아이디
        $list['list'][$i]['mb_id'] = $row['mb_id'];
        // 현황
        $list['list'][$i]['activity_status'] = $row['activity_status'];
        // 직원명
        $list['list'][$i]['mb_name'] = $row['mb_name'];
        // 생년월일
        $list['list'][$i]['birthday'] = wz_get_birth($row['security_number']);
        // 입사일자
        $list['list'][$i]['enter_date'] = '';
        if($row['enter_date'] != '0000-00-00') $list['list'][$i]['enter_date'] = $row['enter_date'];
        // 연락처
        $list['list'][$i]['mb_hp'] = $row['mb_hp'];
        // 서비스
        $list['list'][$i]['service_category'] = $row['service_category'];
        // 계약형태
        $list['list'][$i]['contract_type'] = $row['contract_type'];
        // 팀
        $list['list'][$i]['team_category'] = $row['team_category'];

        $sql2 = " select * from g5_member_education where set_branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}' and set_idx = '{$set_idx}' and edu_year = '{$now_year}' {$where_str} order by edu_date desc, edu_str_hour desc, edu_tit asc ";
        $list['list'][$i]['sql'] = $sql2;
        $qry2 = sql_query($sql2);
        $num2 = sql_num_rows($qry2);

        if($num2 > 0) {
            for($m=0; $row2 = sql_fetch_array($qry2); $m++) {
                $list['list'][$i]['edu'][$m]['idx'] = $row2['idx'];

                $edu_list_sql = " select * from g5_member_education_list where idx = '{$row2['idx']}' and edul_mb_id = '{$row['mb_id']}' ";
                $edu_list_row = sql_fetch($edu_list_sql);
                if($edu_list_row['edul_idx'] == '') {
                    $list['list'][$i]['edu'][$m]['edul_idx'] = '';
                }else{
                    $list['list'][$i]['edu'][$m]['edul_idx'] = $edu_list_row['edul_idx'];
                }
            }
        }else{
            $list['list'][$i]['edu'][0]['idx'] = '';
            $list['list'][$i]['edu'][0]['edul_idx'] = '';
        }
    }
}
/* 회원 리스트 불러오기 END */

echo json_encode($list);