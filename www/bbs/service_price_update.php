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

$branch_id = ($_POST['branch_id'] != '') ? $_POST['branch_id'] : $_SESSION['this_branch_id'];
$spp_year = $_POST['spp_year'];
$client_service = $_POST['client_service'];

// 옵션 데이터
$sop_id = $_POST['sop_id'];
$option_info = $_POST['option_info'];
$spp_price = $_POST['spp_price'];

// 상품 데이터
$spe_id = $_POST['spe_id'];
$spp_info = $_POST['spp_info'];
$spp_subsiby = $_POST['spp_subsiby'];
$spp_deductible = $_POST['spp_deductible'];

if($branch_id == '') {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

if($spp_year == '') {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

if($client_service == '') {
    $list['msg'] = '잘못된 접근입니다!';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

// 옵션 저장
if(count($sop_id) > 0) {
    for($i=0; $i<count($sop_id); $i++) {
        $chk_sql = " select * from g5_service_option_price where sop_id = '{$sop_id[$i]}' and branch_id = '{$branch_id}' and spp_year = '{$spp_year}' ";
        $chk_row = sql_fetch($chk_sql);
        $spp_price_data = preg_replace("/[^0-9]/", "",$spp_price[$i]);
        if($chk_row['spp_id'] == '') {
            $opt_sql = " insert into g5_service_option_price set sop_id = '{$sop_id[$i]}', branch_id = '{$branch_id}', spp_year = '{$spp_year}', spp_price = '{$spp_price_data}', spp_info = '{$option_info[$i]}' ";
        }else{
            $opt_sql = " update g5_service_option_price set spp_price = '{$spp_price_data}' where spp_id = '{$chk_row['spp_id']}' ";
        }
        sql_query($opt_sql);
    }
}

// 상품 저장
if(count($spe_id) > 0) {
    for($i=0; $i<count($spe_id); $i++) {
        $chk_sql = " select * from g5_service_period_price where spe_id = '{$spe_id[$i]}' and branch_id = '{$branch_id}' and spp_year = '{$spp_year}' ";
        $chk_row = sql_fetch($chk_sql);
        if(!$spp_subsiby[$i]) $spp_subsiby[$i] = 0;
        $spp_subsiby_data = preg_replace("/[^0-9]/", "",$spp_subsiby[$i]);
        $spp_deductible_data = preg_replace("/[^0-9]/", "",$spp_deductible[$i]);
        if($chk_row['spp_id'] == '') {
            $sql = " insert into g5_service_period_price set spe_id = '{$spe_id[$i]}', branch_id = '{$branch_id}', spp_year = '{$spp_year}', spp_subsiby = '{$spp_subsiby_data}', spp_deductible = '{$spp_deductible_data}', spp_info = '{$spp_info[$i]}' ";
        }else{
            $sql = " update g5_service_period_price set spp_subsiby = '{$spp_subsiby_data}', spp_deductible = '{$spp_deductible_data}' where spp_id = '{$chk_row['spp_id']}' ";
        }
        sql_query($sql);
    }
}

$list['msg'] = '고객 서비스 금액이 저장되었습니다.';
$list['code'] = '0000';
$list['mb_id'] = $mb_id;

echo json_encode($list);
exit;