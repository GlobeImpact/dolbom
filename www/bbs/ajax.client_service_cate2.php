<?php
include_once('./_common.php');

$list = Array();

$client_service = $_POST['client_service'];
$cl_service_cate = $_POST['cl_service_cate'];

$menu_group_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 4 and sme_code like '{$cl_service_cate}%' and sme_use = 1 order by sme_order asc, sme_code asc ";
$menu_group_qry = sql_query($menu_group_sql);
$menu_group_num = sql_num_rows($menu_group_qry);
if($menu_group_num > 0) {
    for($i=0; $menu_group_row = sql_fetch_array($menu_group_qry); $i++) {
        $list[$i]['group'] = $menu_group_row['sme_name'];

        $service_menu2_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_code like '{$menu_group_row['sme_code']}%' and sme_use = 1 order by sme_order asc, sme_code asc ";
        $service_menu2_qry = sql_query($service_menu2_sql);
        $service_menu2_num = sql_num_rows($service_menu2_qry);
        if($service_menu2_num > 0) {
            for($j=0; $service_menu2_row = sql_fetch_array($service_menu2_qry); $j++) {
                $list[$i]['sme_id'][$j] = $service_menu2_row['sme_id'];
                $list[$i]['sme_name'][$j] = $service_menu2_row['sme_name'];
            }
        }
    }
}

echo json_encode($list);