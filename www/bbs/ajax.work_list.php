<?php
include_once('./_common.php');

// FIlter : 서비스분류
$sch_service_cate = $_POST['sch_service_cate'];
// Filter : 접수기간(STR)
$sch_str_receipt_date = $_POST['sch_str_receipt_date'];
// Filter : 접수기간(END)
$sch_end_receipt_date = $_POST['sch_end_receipt_date'];
// Filter : 신청인(고객명)
$sch_cl_name = $_POST['sch_cl_name'];
// Filter : 연락처(고객 연락처)
$sch_cl_hp = $_POST['sch_cl_hp'];
// Filter : 접수상태
$sch_status = $_POST['sch_status'];
// 우선순위
$sort_orderby = $_POST['sort_orderby'];

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and client_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and cl_hide = ''";

// FIlter : 서비스분류 조건설정
if($sch_service_cate != '') {
    $sch_service_cate_arr = explode('|', $sch_service_cate);
    if(count($sch_service_cate_arr) > 1) {
        $where_str .= " and (";
        for($i=0; $i<count($sch_service_cate_arr); $i++) {
            if($i == 0) {
                $where_str .= "cl_service_cate = '{$sch_service_cate_arr[$i]}'";
            }else{
                $where_str .= " or cl_service_cate = '{$sch_service_cate_arr[$i]}'";
            }
        }
        $where_str .= ")";
    }else{
        $where_str .= " and cl_service_cate = '{$sch_service_cate}'";
    }
}

// Filter : 접수기간 조건설정
if($sch_str_receipt_date != '' && $sch_end_receipt_date != '') {
    $where_str .= " and (receipt_date >= '{$sch_str_receipt_date}' and receipt_date <= '{$sch_end_receipt_date}')";
}else if($sch_str_receipt_date != '') {
    $where_str .= " and receipt_date >= '{$sch_str_receipt_date}'";
}else if($sch_end_receipt_date != '') {
    $where_str .= " and receipt_date <= '{$sch_end_receipt_date}'";
}

// Filter : 신청인(고객명) 조건설정
if($sch_cl_name != '') {
    $where_str .= " and cl_name like '%{$sch_cl_name}%'";
}

// Filter : 연락처(고객 연락처) 조건설정
if($sch_cl_hp != '') {
    $where_str .= " and replace(cl_hp,'-','') like '%{$sch_cl_hp}%'";
}

// Filter : 접수상태 조건설정
if($sch_status != '') {
    if($sch_status == '사용') {
        $where_str .= " and end_date = '0000-00-00' and cancel_date = '0000-00-00'";
    }else if($sch_status == '종료') {
        $where_str .= " and end_date != '0000-00-00'";
    }else if($sch_status == '취소') {
        $where_str .= " and cancel_date != '0000-00-00'";
    }
}

if($sort_orderby == '') {
    $orderby_str .= " receipt_date desc, cl_name asc";
}else{
    $orderby_str .= substr($sort_orderby, 1);
}

$sql = " select * from g5_client where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['client_idx'] = $row['client_idx'];
        $list[$i]['use_status'] = '사용';
        if(($row['end_date'] == '' || $row['end_date'] != '0000-00-00') && date('Y-m-d') > $row['end_date']) $list[$i]['use_status'] = '종료';
        if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $list[$i]['use_status'] = '취소';

        if($row['client_service'] == '아가마지') {
            // 서비스분류
            $smn_sql = " select * from g5_service_menu where sme_code = '{$row['cl_service_cate']}' ";
            $smn_row = sql_fetch($smn_sql);
            $list[$i]['client_service'] = ($smn_row['sme_id'] != '')?$smn_row['sme_name']:'';
            $list[$i]['client_service_data'] = $row['client_service'];

            // 서비스구분
            $sca2_sql = " select * from g5_service_menu where sme_id = '{$row['cl_service_cate2']}' ";
            $sca2_row = sql_fetch($sca2_sql);
            $list[$i]['cl_service_cate2'] = '';
            if($sca2_row['sme_name'] != '') $list[$i]['cl_service_cate2'] = $sca2_row['sme_name'];

        }else{
            // 서비스분류
            $list[$i]['client_service'] = $row['client_service'];
            $list[$i]['client_service_data'] = $row['client_service'];

            // 서비스구분
            $sca2_sql = " select * from g5_service_period where sme_id = '{$row['cl_service_cate2']}' ";
            $sca2_row = sql_fetch($sca2_sql);
            $list[$i]['cl_service_cate2'] = '';
            if($sca2_row['spe_name'] != '') $list[$i]['cl_service_cate2'] = $sca2_row['spe_name'];
        }

        // 서비스기간
        $spe_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where spe_id = '{$row['cl_service_period']}' ";
        $spe_row = sql_fetch($spe_sql);
        if($row['cl_service_cate'] == 10 || $row['cl_service_cate'] == 20) {
            $list[$i]['cl_service_period'] = ($spe_row['spe_info'] != '')?$spe_row['spe_info']:'';
        }else if($row['cl_service_cate'] == 30) {
            $list[$i]['cl_service_period'] = ($spe_row['spe_name'] != '')?$spe_row['spe_name']:'';
        }else{
            $list[$i]['cl_service_period'] = ($spe_row['spe_cate'] != '')?$spe_row['spe_cate']:'';
        }

        $list[$i]['bg_color'] = '';
        if($row['str_date'] != '' && $row['str_date'] != '0000-00-00') $list[$i]['bg_color'] = 'yellow_bg';
        if( ($row['str_date'] != '' && $row['str_date'] != '0000-00-00') && ($row['end_date'] != '' && $row['end_date'] != '0000-00-00') ) $list[$i]['bg_color'] = 'red_bg';
        // 접수일
        $list[$i]['receipt_date'] = $row['receipt_date'];
        // 신청인
        $list[$i]['cl_name'] = $row['cl_name'];
        // 연락처
        $list[$i]['cl_hp'] = $row['cl_hp'];
        // 주민번호
        $list[$i]['cl_security_number'] = substr($row['cl_security_number'], 0, 8);
        // 시작일
        $list[$i]['str_date'] = ($row['str_date'] == '0000-00-00')?'':$row['str_date'];
        // 종료일
        $list[$i]['end_date'] = ($row['end_date'] == '0000-00-00')?'':$row['end_date'];
        // 취소일
        $list[$i]['cancel_date'] = ($row['cancel_date'] == '0000-00-00')?'':$row['cancel_date'];
        // CCTV
        $list[$i]['cctv'] = $row['cl_cctv'];
        // 반려동물
        $list[$i]['pet'] = '';
        if($row['cl_pet_dog'] == 'y') $list[$i]['pet'] .= '<p>애완견'.(($row['cl_pet_dog_cnt'] > 0)?'('.$row['cl_pet_dog_cnt'].')':'').'</p>';
        if($row['cl_pet_cat'] == 'y') $list[$i]['pet'] .= '<p>애완묘'.(($row['cl_pet_cat_cnt'] > 0)?'('.$row['cl_pet_cat_cnt'].')':'').'</p>';

        // 사전면접
        $list[$i]['prior_interview'] = $row['cl_prior_interview'];

        $list[$i]['area_x'] = $row['cl_area_x'];
        $list[$i]['area_y'] = $row['cl_area_y'];
    }
}

echo json_encode($list);