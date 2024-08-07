<?php
include_once('./_common.php');

$mode = $_POST['mode'];

$sch_service_category = '';
$sch_cl_name = '';
$client_idx = $_POST['client_idx'];
$sort_orderby = $_POST['sort_orderby'];

if($client_idx == '') {
    $sch_service_category = $_POST['sch_service_category'];
    $sch_cl_name = $_POST['sch_cl_name'];
    $sch_cl_name = str_replace('-', '', $sch_cl_name);
}

if($mode == 'collect') {
    $sch_str_selected_date = $_POST['sch_str_selected_date'];
    $sch_end_selected_date = $_POST['sch_end_selected_date'];
    $sch_cl_name = $_POST['sch_cl_name'];
    $sch_cl_hp = $_POST['sch_cl_hp'];
    $sch_status = $_POST['sch_status'];
    $sch_deposit_status = $_POST['sch_deposit_status'];
}

$list = Array();

$where_str = "";
$orderby_str = "";

$where_str .= " and client_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and cl_hide = ''";

if($sch_service_category != '') {
    $where_str .= " and cl_service_cate = '{$sch_service_category}'";
}

if($sch_cl_name != '') {
    $where_str .= " and (cl_name like '%{$sch_cl_name}%' or replace(cl_hp,'-','') like '%{$sch_cl_name}%')";
}

if($client_idx != '') {
    $orderby_str .= " client_idx = '{$client_idx}' desc".$sort_orderby;
}else{
    $orderby_str .= substr($sort_orderby, 1);
}

$sql = " select * from g5_client where (1=1) {$where_str} order by {$orderby_str} ";

if($mode == 'collect') {
    $where_str = "";
    
    if($sch_service_category != '') {
        $where_str .= " and a.cl_service_cate = '{$sch_service_category}'";
    }

    if($sch_cl_name != '') {
        $where_str .= " and a.cl_name like '%{$sch_cl_name}%'";
    }

    if($sch_cl_hp != '') {
        $where_str .= " and a.cl_hp like '%{$sch_cl_name}%'";
    }

    if($sch_status != '') {
        $where_str .= " and b.status = '{$sch_status}'";
    }

    if($sch_deposit_status != '') {
        $where_str .= " and b.deposit_status = '{$sch_deposit_status}'";
    }

    $sql = " select * from g5_client as a inner join g5_work as b on b.client_idx = a.client_idx where a.client_menu = '{$_SESSION['this_code']}' and a.branch_id = '{$_SESSION['this_branch_id']}' and a.cl_hide = '' {$where_str} order by {$orderby_str} ";
}

$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    for($i=0; $row = sql_fetch_array($qry); $i++) {
        $list[$i]['client_idx'] = $row['client_idx'];
        $list[$i]['cl_name'] = $row['cl_name'];
        $list[$i]['cl_hp'] = $row['cl_hp'];
        // 접수일
        $list[$i]['receipt_date'] = ($row['receipt_date'] == '0000-00-00')?'':$row['receipt_date'];
        // 주소
        $list[$i]['cl_addr'] = $row['cl_addr1'];
        // 시작일자
        $list[$i]['str_date'] = ($row['str_date'] == '0000-00-00')?'':$row['str_date'];
        // 종료일자
        $list[$i]['end_date'] = ($row['end_date'] == '0000-00-00')?'':$row['end_date'];
        $list[$i]['use_status'] = '사용';
        if(($row['end_date'] == '' || $row['end_date'] != '0000-00-00') && date('Y-m-d') > $row['end_date']) $list[$i]['use_status'] = '종료';
        if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $list[$i]['use_status'] = '취소';

        /* 아가마지 */
        // 출산예정일
        $list[$i]['cl_birth_due_date'] = ($row['cl_birth_due_date'] == '0000-00-00')?'':$row['cl_birth_due_date'];
        // 출산순위
        $list[$i]['cl_baby_count'] = $row['cl_baby_count'];
        // 출산아기
        $list[$i]['cl_baby'] = $row['cl_baby'];

        /* 가사서비스 */
        // 연장근무
        $list[$i]['cl_overtime'] = ($row['cl_overtime'] == 'y')?'있음':'';
        // 출산순위
        $list[$i]['cl_baby_count'] = $row['cl_baby_count'];

        if($client_idx != '' && $client_idx == $row['client_idx']) {
            $list[$i]['list_selected'] = 'y';
        }else{
            if($client_idx == '' && $i == 0) {
                $list[$i]['list_selected'] = 'y';
            }else{
                $list[$i]['list_selected'] = '';
            }
        }

        $menu_sql = " select * from g5_service_menu where client_menu = '{$_SESSION['this_code']}' and sme_code = '{$row['cl_service_cate']}' ";
        $menu_row = sql_fetch($menu_sql);
        $list[$i]['service_category'] = $menu_row['sme_name'];
    }
}

echo json_encode($list);