<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$list = Array();

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if(!$is_member) {
    $list['msg'] = '로그인이 필요합니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if($member['mb_level'] < 5) {
    $list['msg'] = '매니저 또는 관리자 접속이 필요합니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

$paste_branch_id = ($_POST['paste_branch_id'] != '') ? $_POST['paste_branch_id'] : $_SESSION['this_branch_id'];
$paste_year = $_POST['paste_year'];
$copy_branch_id = ($_POST['copy_branch_id'] != '') ? $_POST['copy_branch_id'] : '';
$copy_year = $_POST['copy_year'];
$service_category_arr = $_POST['service_category_arr'];

if($paste_branch_id == '') {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

if($copy_branch_id == '') {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

if($paste_branch_id == $copy_branch_id) {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

if($copy_year == '') {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

if($paste_branch_id && $copy_branch_id && $copy_year) {
    if(count($service_category_arr) > 0) {
        for($i=0; $i<count($service_category_arr); $i++) {
            // 옵션 저장
            $opt_call_sql = " select a.* from g5_service_option_price as a left join g5_service_option as b on b.sop_id = a.sop_id where b.client_service = '{$service_category_arr[$i]}' and a.branch_id = '{$copy_branch_id}' and a.spp_year = '{$copy_year}' ";
            $opt_call_qry = sql_query($opt_call_sql);
            $opt_call_num = sql_num_rows($opt_call_qry);
            if($opt_call_num > 0) {
                for($j=0; $opt_call_row = sql_fetch_array($opt_call_qry); $j++) {
                    $opt_chk_sql = " select * from g5_service_option_price where sop_id = '{$opt_call_row['sop_id']}' and branch_id = '{$paste_branch_id}' and spp_year = '{$paste_year}' ";
                    $opt_chk_row = sql_fetch($opt_chk_sql);
                    if($opt_chk_row['spp_id'] == '') {
                        $opt_sql = " insert into g5_service_option_price set sop_id = '{$opt_call_row['sop_id']}', branch_id = '{$paste_branch_id}', spp_year = '{$paste_year}', spp_price = '{$opt_call_row['spp_price']}', spp_info = '{$opt_call_row['spp_info']}' ";
                    }else{
                        $opt_sql = " update g5_service_option_price set spp_price = '{$opt_call_row['spp_price']}' where spp_id = '{$opt_chk_row['spp_id']}' ";
                    }
                    sql_query($opt_sql);
                }
            }

            // 상품 저장
            $call_sql = " select a.* from g5_service_period_price as a left join g5_service_period as b on b.spe_id = a.spe_id where b.client_service = '{$service_category_arr[$i]}' and a.branch_id = '{$copy_branch_id}' and a.spp_year = '{$copy_year}' ";
            $call_qry = sql_query($call_sql);
            $call_num = sql_num_rows($call_qry);
            if($call_num > 0) {
                for($j=0; $call_row = sql_fetch_array($call_qry); $j++) {
                    $chk_sql = " select * from g5_service_period_price where spe_id = '{$call_row['spe_id']}' and branch_id = '{$paste_branch_id}' and spp_year = '{$paste_year}' ";
                    $chk_row = sql_fetch($chk_sql);
                    if($chk_row['spp_id'] == '') {
                        $sql = " insert into g5_service_period_price set spe_id = '{$call_row['spe_id']}', branch_id = '{$paste_branch_id}', spp_year = '{$paste_year}', spp_subsiby = '{$call_row['spp_subsiby']}', spp_deductible = '{$call_row['spp_deductible']}', spp_info = '{$call_row['spp_info']}' ";
                    }else{
                        $sql = " update g5_service_period_price set spp_subsiby = '{$call_row['spp_subsiby']}', spp_deductible = '{$call_row['spp_deductible']}' where spp_id = '{$chk_row['spp_id']}' ";
                    }
                    sql_query($sql);
                }
            }
        }
    }
}

$list['msg'] = '데이터를 불러와 저장되었습니다.';
$list['code'] = '0000';
$list['mb_id'] = $mb_id;

echo json_encode($list);
exit;