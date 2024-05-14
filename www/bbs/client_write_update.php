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

// 매니저 등록/수정 권한 확인
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'write' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $list['msg'] = '등록/수정 권한이 없습니다.';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }
}

$client_idx = isset($_POST['client_idx']) ? trim($_POST['client_idx']) : '';

$branch_id                  = isset($_POST['branch_id'])                  ? trim($_POST['branch_id'])                : "";
$client_service             = isset($_POST['client_service']) ? trim($_POST['client_service']) : '';
$receipt_date               = isset($_POST['receipt_date']) ? trim($_POST['receipt_date']) : '';
$str_date                   = isset($_POST['str_date']) ? trim($_POST['str_date']) : '';
$end_date                   = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
$cancel_date                = isset($_POST['cancel_date']) ? trim($_POST['cancel_date']) : '';
$cl_name                    = isset($_POST['cl_name']) ? trim($_POST['cl_name']) : '';
$cl_security_number         = isset($_POST['cl_security_number']) ? trim($_POST['cl_security_number']) : '';
$cl_hp                      = isset($_POST['cl_hp']) ? trim($_POST['cl_hp']) : '';
$cl_tel                     = isset($_POST['cl_tel']) ? trim($_POST['cl_tel']) : '';
$cl_birth_type              = isset($_POST['cl_birth_type']) ? trim($_POST['cl_birth_type']) : '';
$cl_birth_due_date          = isset($_POST['cl_birth_due_date']) ? trim($_POST['cl_birth_due_date']) : '';
$cl_birth_date              = isset($_POST['cl_birth_date']) ? trim($_POST['cl_birth_date']) : '';
$cl_zip                     = isset($_POST['cl_zip']) ? trim($_POST['cl_zip']) : '';
$cl_addr1                   = isset($_POST['cl_addr1']) ? trim($_POST['cl_addr1']) : '';
$cl_addr2                   = isset($_POST['cl_addr2']) ? trim($_POST['cl_addr2']) : '';
$cl_addr3                   = isset($_POST['cl_addr3']) ? trim($_POST['cl_addr3']) : '';
$cl_addr_jibeon             = isset($_POST['cl_addr_jibeon']) ? trim($_POST['cl_addr_jibeon']) : '';
$cl_area                    = isset($_POST['cl_area']) ? trim($_POST['cl_area']) : '';
$cl_area_x                  = isset($_POST['cl_area_x']) ? trim($_POST['cl_area_x']) : '';
$cl_area_y                  = isset($_POST['cl_area_y']) ? trim($_POST['cl_area_y']) : '';
$cl_memo1                   = isset($_POST['cl_memo1']) ? trim($_POST['cl_memo1']) : '';
$cl_memo2                   = isset($_POST['cl_memo2']) ? trim($_POST['cl_memo2']) : '';
$cl_service_cate            = isset($_POST['cl_service_cate']) ? trim($_POST['cl_service_cate']) : '';
$cl_service_cate2           = isset($_POST['cl_service_cate2']) ? trim($_POST['cl_service_cate2']) : '';
$cl_service_period          = isset($_POST['cl_service_period']) ? trim($_POST['cl_service_period']) : '';
$cl_service_option          = isset($_POST['cl_service_option']) ? trim($_POST['cl_service_option']) : '';
$cl_baby                    = isset($_POST['cl_baby']) ? trim($_POST['cl_baby']) : '';
$cl_baby_gender             = isset($_POST['cl_baby_gender']) ? trim($_POST['cl_baby_gender']) : '';
$cl_baby_count              = isset($_POST['cl_baby_count']) ? trim($_POST['cl_baby_count']) : '';
$cl_baby_first              = isset($_POST['cl_baby_first']) ? trim($_POST['cl_baby_first']) : '';
$cl_school                  = isset($_POST['cl_school']) ? trim($_POST['cl_school']) : '';
$cl_preschool               = isset($_POST['cl_preschool']) ? trim($_POST['cl_preschool']) : '';
$cl_cctv                    = isset($_POST['cl_cctv']) ? trim($_POST['cl_cctv']) : '';
$cl_pet                     = isset($_POST['cl_pet']) ? trim($_POST['cl_pet']) : '';
$cl_surcharge               = isset($_POST['cl_surcharge']) ? trim($_POST['cl_surcharge']) : '';
$cl_premium_use             = isset($_POST['cl_premium_use']) ? trim($_POST['cl_premium_use']) : '';
$cl_unit_price              = isset($_POST['cl_unit_price']) ? trim($_POST['cl_unit_price']) : '';
$cl_tot_price               = isset($_POST['cl_tot_price']) ? trim($_POST['cl_tot_price']) : '';
$cl_memo3                   = isset($_POST['cl_memo3']) ? trim($_POST['cl_memo3']) : '';
$cl_prior_interview         = isset($_POST['cl_prior_interview']) ? trim($_POST['cl_prior_interview']) : '';
$cl_cash_receipt            = isset($_POST['cl_cash_receipt']) ? trim($_POST['cl_cash_receipt']) : '';
$cl_overtime                = isset($_POST['cl_overtime']) ? trim($_POST['cl_overtime']) : '';
$cl_twins                   = isset($_POST['cl_twins']) ? trim($_POST['cl_twins']) : '';
$cl_regdate                 = date('Y-m-d H:i:s');

$cl_service_str_date        = isset($_POST['cl_service_str_date']) ? trim($_POST['cl_service_str_date']) : '';
$cl_service_end_date        = isset($_POST['cl_service_end_date']) ? trim($_POST['cl_service_end_date']) : '';
$cl_service_time            = isset($_POST['cl_service_time']) ? trim($_POST['cl_service_time']) : '';
$cl_relationship            = isset($_POST['cl_relationship']) ? trim($_POST['cl_relationship']) : '';
$cl_baby_name               = isset($_POST['cl_baby_name']) ? trim($_POST['cl_baby_name']) : '';
$cl_baby_birth              = isset($_POST['cl_baby_birth']) ? trim($_POST['cl_baby_birth']) : '';
$cl_add_service0            = isset($_POST['cl_add_service0']) ? trim($_POST['cl_add_service0']) : '';
$cl_add_service1            = isset($_POST['cl_add_service1']) ? trim($_POST['cl_add_service1']) : '';
$cl_add_service2            = isset($_POST['cl_add_service2']) ? trim($_POST['cl_add_service2']) : '';
$cl_house_area              = isset($_POST['cl_house_area']) ? trim($_POST['cl_house_area']) : '';
$cl_product                 = isset($_POST['cl_product']) ? trim($_POST['cl_product']) : '';
$cl_recommended             = isset($_POST['cl_recommended']) ? trim($_POST['cl_recommended']) : '';
$cl_work_select_mb_id       = isset($_POST['cl_work_select_mb_id']) ? trim($_POST['cl_work_select_mb_id']) : '';

if ($w == '') {
    $sql = " insert into g5_client set 
        branch_id = '{$branch_id}', 
        client_menu = '{$_SESSION['this_code']}', 
        client_service = '{$client_service}', 
        receipt_date = '{$receipt_date}', 
        str_date = '{$str_date}', 
        end_date = '{$end_date}', 
        cancel_date = '{$cancel_date}', 
        cl_name = '{$cl_name}', 
        cl_security_number = '{$cl_security_number}', 
        cl_hp = '{$cl_hp}', 
        cl_tel = '{$cl_tel}', 
        cl_birth_type = '{$cl_birth_type}', 
        cl_birth_due_date = '{$cl_birth_due_date}', 
        cl_birth_date = '{$cl_birth_date}', 
        cl_zip = '{$cl_zip}', 
        cl_addr1 = '{$cl_addr1}', 
        cl_addr2 = '{$cl_addr2}', 
        cl_addr3 = '{$cl_addr3}', 
        cl_addr_jibeon = '{$cl_addr_jibeon}', 
        cl_area = '{$cl_area}', 
        cl_area_x = '{$cl_area_x}', 
        cl_area_y = '{$cl_area_y}', 
        cl_memo1 = '{$cl_memo1}', 
        cl_memo2 = '{$cl_memo2}', 
        cl_service_cate = '{$cl_service_cate}', 
        cl_service_cate2 = '{$cl_service_cate2}', 
        cl_service_period = '{$cl_service_period}', 
        cl_service_option = '{$cl_service_option}', 
        cl_baby = '{$cl_baby}', 
        cl_baby_gender = '{$cl_baby_gender}', 
        cl_baby_count = '{$cl_baby_count}', 
        cl_baby_first = '{$cl_baby_first}', 
        cl_school = '{$cl_school}', 
        cl_preschool = '{$cl_preschool}', 
        cl_cctv = '{$cl_cctv}', 
        cl_pet = '{$cl_pet}', 
        cl_surcharge = '{$cl_surcharge}', 
        cl_premium_use = '{$cl_premium_use}', 
        cl_unit_price = '{$cl_unit_price}', 
        cl_tot_price = '{$cl_tot_price}', 
        cl_memo3 = '{$cl_memo3}', 
        cl_prior_interview = '{$cl_prior_interview}', 
        cl_service_str_date = '{$cl_service_str_date}', 
        cl_service_end_date = '{$cl_service_end_date}', 
        cl_service_time = '{$cl_service_time}', 
        cl_relationship = '{$cl_relationship}', 
        cl_baby_name = '{$cl_baby_name}', 
        cl_baby_birth = '{$cl_baby_birth}', 
        cl_cash_receipt = '{$cl_cash_receipt}', 
        cl_overtime = '{$cl_overtime}', 
        cl_twins = '{$cl_twins}', 
        cl_recommended = '{$cl_recommended}', 
        cl_work_select_mb_id = '{$cl_work_select_mb_id}', 
        cl_regdate = '{$cl_regdate}' 
    ";
    if(sql_query($sql)) {
        $client_idx = sql_insert_id();

        if($client_service == '아가마지' && $cl_work_select_mb_id != '') {
            $work_sql = " insert into g5_work set client_idx = '{$client_idx}', mb_id = '{$cl_work_select_mb_id}', status = '대기', work_hide = '', reg_date = '{$cl_regdate}' ";
            if(sql_query($work_sql)) {
                $w_idx = sql_insert_id();
                $work_history_sql = " insert into g5_work_member_history set w_idx = '{$w_idx}', prev_mb_id = '', change_mb_id = '{$cl_work_select_mb_id}', reg_date = '{$cl_regdate}' ";
                sql_query($work_history_sql);
            }
        }

        $list['msg'] = '고객접수등록이 완료되었습니다';
        $list['code'] = '0000';
        $list['client_idx'] = $client_idx;
    }else{
        $list['msg'] = '고객접수등록에 실패하였습니다';
        $list['code'] = '9999';
    }

} else if ($w == 'u') {
    $sql = " update g5_client set 
        receipt_date = '{$receipt_date}', 
        str_date = '{$str_date}', 
        end_date = '{$end_date}', 
        cancel_date = '{$cancel_date}', 
        cl_name = '{$cl_name}', 
        cl_security_number = '{$cl_security_number}', 
        cl_hp = '{$cl_hp}', 
        cl_tel = '{$cl_tel}', 
        cl_birth_type = '{$cl_birth_type}', 
        cl_birth_due_date = '{$cl_birth_due_date}', 
        cl_birth_date = '{$cl_birth_date}', 
        cl_zip = '{$cl_zip}', 
        cl_addr1 = '{$cl_addr1}', 
        cl_addr2 = '{$cl_addr2}', 
        cl_addr3 = '{$cl_addr3}', 
        cl_addr_jibeon = '{$cl_addr_jibeon}', 
        cl_area = '{$cl_area}', 
        cl_area_x = '{$cl_area_x}', 
        cl_area_y = '{$cl_area_y}', 
        cl_memo1 = '{$cl_memo1}', 
        cl_memo2 = '{$cl_memo2}', 
        cl_service_cate = '{$cl_service_cate}', 
        cl_service_cate2 = '{$cl_service_cate2}', 
        cl_service_period = '{$cl_service_period}', 
        cl_service_option = '{$cl_service_option}', 
        cl_baby = '{$cl_baby}', 
        cl_baby_gender = '{$cl_baby_gender}', 
        cl_baby_count = '{$cl_baby_count}', 
        cl_baby_first = '{$cl_baby_first}', 
        cl_school = '{$cl_school}', 
        cl_preschool = '{$cl_preschool}', 
        cl_cctv = '{$cl_cctv}', 
        cl_pet = '{$cl_pet}', 
        cl_surcharge = '{$cl_surcharge}', 
        cl_premium_use = '{$cl_premium_use}', 
        cl_unit_price = '{$cl_unit_price}', 
        cl_tot_price = '{$cl_tot_price}', 
        cl_memo3 = '{$cl_memo3}', 
        cl_prior_interview = '{$cl_prior_interview}', 
        cl_service_str_date = '{$cl_service_str_date}', 
        cl_service_end_date = '{$cl_service_end_date}', 
        cl_service_time = '{$cl_service_time}', 
        cl_relationship = '{$cl_relationship}', 
        cl_baby_name = '{$cl_baby_name}', 
        cl_baby_birth = '{$cl_baby_birth}', 
        cl_cash_receipt = '{$cl_cash_receipt}', 
        cl_overtime = '{$cl_overtime}', 
        cl_twins = '{$cl_twins}', 
        cl_recommended = '{$cl_recommended}', 
        cl_work_select_mb_id = '{$cl_work_select_mb_id}', 
        cl_regdate = '{$cl_regdate}' 
        where client_idx = '{$client_idx}' 
    ";
    if(sql_query($sql)) {
        $work_chk_sql = " select * from g5_work where client_idx = '{$client_idx}' ";
        $work_chk_row = sql_fetch($work_chk_sql);
        if($work_chk_row['mb_id'] != $cl_work_select_mb_id && $cl_work_select_mb_id != '') {
            $work_sql = " update g5_work set mb_id = '{$cl_work_select_mb_id}' where idx = '{$work_chk_row['idx']}' ";
            if(sql_query($work_sql)) {
                $work_history_sql = " insert into g5_work_member_history set w_idx = '{$work_chk_row['idx']}', prev_mb_id = '{$work_chk_row['mb_id']}', change_mb_id = '{$cl_work_select_mb_id}', reg_date = '{$cl_regdate}' ";
                sql_query($work_history_sql);
            }
        }

        $list['msg'] = '고객접수수정이 완료되었습니다';
        $list['code'] = '0000';
        $list['client_idx'] = $client_idx;
    }else{
        $list['msg'] = '고객접수수정이 실패하였습니다';
        $list['code'] = '9999';
    }
}

echo json_encode($list);
exit;
