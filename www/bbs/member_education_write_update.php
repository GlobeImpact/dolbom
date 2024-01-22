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

$edu_idx = $_POST['edu_idx'];
$set_idx = $_POST['set_idx'];
$edu_date = $_POST['edu_date'];
$edu_year = substr($edu_date, 0, 4);
$edu_str_hour = $_POST['edu_str_hour'];
$edu_str_min = $_POST['edu_str_min'];
$edu_end_hour = $_POST['edu_end_hour'];
$edu_end_min = $_POST['edu_end_min'];
$edu_tit = $_POST['edu_tit'];
$edu_method = $_POST['edu_method'];
$edu_content = $_POST['edu_content'];
$edul_mb_id = $_POST['edul_mb_id'];
$edu_reg_date = date('Y-m-d H:i:s');

if ($w == '') {
    $sql = " insert into g5_member_education 
                set set_mb_menu = '{$_SESSION['this_code']}', 
                set_idx = '{$set_idx}', 
                edu_year = '{$edu_year}', 
                edu_date = '{$edu_date}', 
                edu_str_hour = '{$edu_str_hour}', 
                edu_str_min = '{$edu_str_min}', 
                edu_end_hour = '{$edu_end_hour}', 
                edu_end_min = '{$edu_end_min}', 
                edu_tit = '{$edu_tit}', 
                edu_method = '{$edu_method}', 
                edu_content = '{$edu_content}', 
                edu_reg_date = '{$edu_reg_date}' ";
    if(sql_query($sql)) {
        $edu_idx = sql_insert_id();

        if(count($edul_mb_id) > 0) {
            for($i=0; $i<count($edul_mb_id); $i++) {
                $edul_sql = " insert into g5_member_education_list 
                        set edu_idx = '{$edu_idx}', 
                        edul_mb_id = '{$edul_mb_id[$i]}', 
                        edul_reg_date = '{$edu_reg_date}' ";
                sql_query($edul_sql);
            }
        }

        $list['msg'] = '작성이 완료되었습니다';
        $list['code'] = '0000';
    }
} else if ($w == 'u') {
    $sql = " update g5_member_education set 
                edu_year = '{$edu_year}', 
                edu_date = '{$edu_date}', 
                edu_str_hour = '{$edu_str_hour}', 
                edu_str_min = '{$edu_str_min}', 
                edu_end_hour = '{$edu_end_hour}', 
                edu_end_min = '{$edu_end_min}', 
                edu_tit = '{$edu_tit}', 
                edu_method = '{$edu_method}', 
                edu_content = '{$edu_content}' 
            where edu_idx = '{$edu_idx}' ";
    if(sql_query($sql)) {

        $edul_del_sql = " delete from g5_member_education_list where edu_idx = '{$edu_idx}' ";
        sql_query($edul_del_sql);

        if(count($edul_mb_id) > 0) {
            for($i=0; $i<count($edul_mb_id); $i++) {
                $edul_sql = " insert into g5_member_education_list 
                        set edu_idx = '{$edu_idx}', 
                        edul_mb_id = '{$edul_mb_id[$i]}', 
                        edul_reg_date = '{$edu_reg_date}' ";
                sql_query($edul_sql);
            }
        }

        $list['msg'] = '수정이 완료되었습니다';
        $list['code'] = '0000';
    }else{
        $list['msg'] = '수정에 실패하였습니다';
        $list['code'] = '9999';
    }
}

$list['w'] = $w;
$list['edu_idx'] = $edu_idx;

echo json_encode($list);
exit;