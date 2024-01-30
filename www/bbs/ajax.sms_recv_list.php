<?php
include_once('./_common.php');

$user_category = '';
$filter_activity_status = '';
$filter_service_category = '';
$filter_client_service = '';
$filter_service_cate = '';
$filter_user_name = '';

$user_category = $_POST['user_category'];
$filter_activity_status = $_POST['filter_activity_status'];
$filter_service_category = $_POST['filter_service_category'];
$filter_client_service = $_POST['filter_client_service'];
$filter_service_cate = $_POST['filter_service_cate'];
$filter_user_name = $_POST['filter_user_name'];

$list = Array();

$select_str = "";
$where_str = "";
$orderby_str = "";

switch ($user_category) {
    case 'member':
        $select_str .= "select * from g5_member";
        $where_str .= " and mb_menu = '{$_SESSION['this_code']}' and mb_level = '2'";

        if($filter_user_name != '') {
            $where_str .= " and mb_name like '%{$filter_user_name}%'";
        }

        if($filter_activity_status != '') {
            $where_str .= " and activity_status = '{$filter_activity_status}'";
        }

        if($filter_service_category != '') {
            $where_str .= " and service_category = '{$filter_service_category}'";
        }

        $orderby_str .= " mb_name asc";
    break;

    case 'client':
        $select_str .= "select * from g5_client";
        $where_str .= " and client_menu = '{$_SESSION['this_code']}'";

        if($filter_user_name != '') {
            $where_str .= " and cl_name like '%{$filter_user_name}%'";
        }

        if($filter_client_service != '') {
            $where_str .= " and client_service = '{$filter_client_service}'";
        }

        if($filter_service_cate != '') {
            $where_str .= " and cl_service_cate = '{$filter_service_cate}'";
        }

        $orderby_str .= " cancel_date = '0000-00-00' desc, end_date = '0000-00-00' desc, cancel_date desc, end_date desc, cl_name asc";
    break;

    case 'manager':
        $select_str .= "select * from g5_member";
        $where_str .= " and mb_menu = '{$_SESSION['this_code']}' and mb_level = '5'";

        if($filter_user_name != '') {
            $where_str .= " and mb_name like '%{$filter_user_name}%'";
        }

        $orderby_str .= " mb_name asc";
    break;

    default:
    break;
}

$sql = " {$select_str} where (1=1) {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

if($num > 0) {
    switch ($user_category) {
        case 'member':
            for($i=0; $row = sql_fetch_array($qry); $i++) {
                $list[$i]['recv_id'] = $row['mb_id'];
                $list[$i]['recv_name'] = $row['mb_name'];
                $list[$i]['recv_hp'] = $row['mb_hp'];
                $list[$i]['status'] = $row['activity_status'];
                $list[$i]['gender'] = wz_get_gender($row['security_number']);
                if($list[$i]['gender'] != '') $list[$i]['gender'] = $list[$i]['gender'].'자';
                $list[$i]['birth'] = trim(wz_get_birth($row['security_number']));
                $list[$i]['date'] = $row['enter_date'];
            }
        break;

        case 'client':
            for($i=0; $row = sql_fetch_array($qry); $i++) {
                $list[$i]['recv_id'] = $row['client_idx'];
                $list[$i]['recv_name'] = $row['cl_name'];
                $list[$i]['recv_hp'] = $row['cl_hp'];
                $list[$i]['service'] = $row['client_service'];
                $list[$i]['status'] = '사용';
                if($row['end_date'] == '' || $row['end_date'] != '0000-00-00') $list[$i]['status'] = '종료';
                if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $list[$i]['status'] = '취소';
            }
        break;

        case 'manager':
            for($i=0; $row = sql_fetch_array($qry); $i++) {
                $list[$i]['recv_id'] = $row['mb_id'];
                $list[$i]['recv_name'] = $row['mb_name'];
                $list[$i]['recv_hp'] = $row['mb_hp'];
                $list[$i]['birth'] = trim(wz_get_birth($row['security_number']));
            }
        break;

        default:
        break;
    }
}

echo json_encode($list);