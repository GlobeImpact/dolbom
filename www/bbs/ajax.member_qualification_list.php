<?php
include_once('./_common.php');

$list = Array();
$list['list'] = Array();

$set_idx = $_POST['set_idx'];
$now_year = $_POST['now_year'];
$sch_value = $_POST['sch_value'];

if($set_idx != '') $set_where_str = " and set_idx = '{$set_idx}'";
$set_sql = " select * from g5_member_qualification_set where set_hide = '' {$set_where_str} ";
$set_qry = sql_query($set_sql);
$set_num = sql_num_rows($set_qry);

$set_qry2 = sql_query($set_sql);
$set_num2 = sql_num_rows($set_qry2);

/* List Table HD 추출 STR */
$menu_cell = '';
$cell_width_tot = 725.88;
$cell_width = $cell_width_tot / $set_num;

$list['cell_count'] = $set_num;
$list['cell_width'] = $cell_width;

switch ($set_idx) {
    case '':
        $menu_cell = '';

        if($set_num > 0) {
            for($m=0; $set_row = sql_fetch_array($set_qry); $m++) {
                $menu_cell .= '<th style="width:'.$cell_width.'px;">'.$set_row['set_tit'].'</th>';
            }
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb" rowspan="2">번호</th>
            <th class="layer_list_activity_status" rowspan="2">현황</th>
            <th class="layer_list_name" rowspan="2">직원명</th>
            <th class="layer_list_date" rowspan="2">생년월일</th>
            <th class="layer_list_date" rowspan="2">입사일자</th>
            <th colspan="'.$set_num.'">자격관리</th>
        </tr>
        <tr>'.$menu_cell.'</tr>
        ';
    break;

    default:
        $menu_cell = '';

        if($set_num > 0) {
            for($m=0; $set_row = sql_fetch_array($set_qry); $m++) {
                $menu_cell .= '<th>'.$set_row['set_tit'].'</th>';
            }
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb" rowspan="2">번호</th>
            <th class="layer_list_activity_status" rowspan="2">현황</th>
            <th class="layer_list_name" rowspan="2">직원명</th>
            <th class="layer_list_date" rowspan="2">생년월일</th>
            <th class="layer_list_date" rowspan="2">입사일자</th>
            <th class="layer_list_tel" rowspan="2">연락처</th>
            <th class="layer_list_service_category" rowspan="2">서비스</th>
            <th class="layer_list_status" rowspan="2">계약형태</th>
            <th class="layer_list_numb" rowspan="2">팀</th>
            <th>자격관리</th>
        </tr>
        <tr>'.$menu_cell.'</tr>
        ';
    break;
}
/* List Table HD 추출 END */

/* 회원 리스트 불러오기 STR */
$where_str = "";
$orderby_str = "";

if($sch_value != '') {
    $where_str .= " and mb_name like '%{$sch_value}%'";
}

$orderby_str .= " activity_status = '활동중' desc, activity_status = '보류' desc, mb_name asc";

$sql = " select * from g5_member where branch_id = '{$_SESSION['this_branch_id']}' and mb_menu = '{$_SESSION['this_code']}' and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') {$where_str} order by {$orderby_str} ";
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

        $set_sql2 = " select * from g5_member_qualification_set where set_hide = '' {$set_where_str} ";
        $set_qry2 = sql_query($set_sql2);
        $set_num2 = sql_num_rows($set_qry2);
        if($set_num2 > 0) {
            for($m=0; $set_row2 = sql_fetch_array($set_qry2); $m++) {
                $list['list'][$i]['qualification'][$m]['set_idx'] = $set_row2['set_idx'];

                $qualification_sql = " select * from g5_member_qualification where set_idx = '{$set_row2['set_idx']}' and input_year = '{$now_year}' and mb_id = '{$row['mb_id']}' ";
                $qualification_row = sql_fetch($qualification_sql);
                if($qualification_row['idx'] == '') {
                    $list['list'][$i]['qualification'][$m]['idx'] = '';
                    $list['list'][$i]['qualification'][$m]['diagnosis_date'] = '';
                    $list['list'][$i]['qualification'][$m]['judgment_date'] = '';
                    $list['list'][$i]['qualification'][$m]['confirm_date'] = '';
                }else{
                    $list['list'][$i]['qualification'][$m]['idx'] = $qualification_row['idx'];
                    $list['list'][$i]['qualification'][$m]['diagnosis_date'] = $qualification_row['diagnosis_date'];
                    if($qualification_row['diagnosis_date'] == '0000-00-00') $list['list'][$i]['qualification'][$m]['diagnosis_date'] = '';
                    $list['list'][$i]['qualification'][$m]['judgment_date'] = $qualification_row['judgment_date'];
                    if($qualification_row['judgment_date'] == '0000-00-00') $list['list'][$i]['qualification'][$m]['judgment_date'] = '';
                    $list['list'][$i]['qualification'][$m]['confirm_date'] = $qualification_row['confirm_date'];
                    if($qualification_row['confirm_date'] == '0000-00-00') $list['list'][$i]['qualification'][$m]['confirm_date'] = '';
                }
            }
        }
    }
}
/* 회원 리스트 불러오기 END */

echo json_encode($list);