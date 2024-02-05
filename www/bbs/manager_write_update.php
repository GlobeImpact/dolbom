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
if(!$is_admin) {
    $list['msg'] = '최고관리자만 접근할 수 있습니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';

// 수정일 경우 아이디가 틀리면 수정 불가
if($w == 'u') {
    $prev_mb_id = isset($_POST['prev_mb_id']) ? trim($_POST['prev_mb_id']) : '';

    if($mb_id != $prev_mb_id) {
        $list['msg'] = '아이디가 틀립니다.';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }
}

$set_level = 5;

$mb_name        = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : '';
$mb_nick        = $mb_name;
$mb_hp          = isset($_POST['mb_hp'])            ? trim($_POST['mb_hp'])          : "";
$mb_zip1        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 0, 3) : "";
$mb_zip2        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 3)    : "";
$mb_addr1       = isset($_POST['mb_addr1'])         ? trim($_POST['mb_addr1'])       : "";
$mb_addr2       = isset($_POST['mb_addr2'])         ? trim($_POST['mb_addr2'])       : "";
$mb_addr3       = isset($_POST['mb_addr3'])         ? trim($_POST['mb_addr3'])       : "";
$mb_addr_jibeon = isset($_POST['mb_addr_jibeon'])   ? trim($_POST['mb_addr_jibeon']) : "";
$mb_area        = isset($_POST['mb_area'])          ? trim($_POST['mb_area'])        : "";
$mb_area_x      = isset($_POST['mb_area_x'])        ? trim($_POST['mb_area_x'])      : "";
$mb_area_y      = isset($_POST['mb_area_y'])        ? trim($_POST['mb_area_y'])      : "";

$branch_id          = isset($_POST['branch_id'])                  ? trim($_POST['branch_id'])                : "";
$security_number    = isset($_POST['security_number'])            ? trim($_POST['security_number'])          : "";
$activity_status    = isset($_POST['activity_status'])            ? trim($_POST['activity_status'])          : "";
$enter_date         = isset($_POST['enter_date'])                 ? trim($_POST['enter_date'])               : "";
$quit_date          = isset($_POST['quit_date'])                  ? trim($_POST['quit_date'])                : "";
$mb_memo            = isset($_POST['mb_memo'])                    ? trim($_POST['mb_memo'])                  : "";

$mb_name        = clean_xss_tags($mb_name);
$mb_zip1        = preg_replace('/[^0-9]/', '', $mb_zip1);
$mb_zip2        = preg_replace('/[^0-9]/', '', $mb_zip2);
$mb_addr1       = clean_xss_tags($mb_addr1);
$mb_addr2       = clean_xss_tags($mb_addr2);
$mb_addr3       = clean_xss_tags($mb_addr3);
$mb_addr_jibeon = preg_match("/^(N|R)$/", $mb_addr_jibeon) ? $mb_addr_jibeon : '';

$mb_password    = isset($_POST['mb_password']) ? trim($_POST['mb_password']) : '';

if($quit_date != '') {
    $activity_status = '퇴사';
}

$management = $_POST['management'];

run_event('register_form_update_before', $mb_id, $w);

if ($w == '' || $w == 'u') {
    if ($msg = empty_mb_id($mb_id)) {
        $list['msg'] = $msg;
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }
    if ($msg = count_mb_id($mb_id)) {
        $list['msg'] = $msg;
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }

    // 이름, 닉네임에 utf-8 이외의 문자가 포함됐다면 오류
    // 서버환경에 따라 정상적으로 체크되지 않을 수 있음.
    $tmp_mb_name = iconv('UTF-8', 'UTF-8//IGNORE', $mb_name);
    if($tmp_mb_name != $mb_name) {
        $list['msg'] = '이름을 올바르게 입력해주세요';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }

    // 비밀번호를 체크하는 상태의 기본값은 true이며, 비밀번호를 체크하지 않으려면 hook 을 통해 false 값으로 바꿔야 합니다.
    $is_check_password = run_replace('register_member_password_check', true, $mb_id, '', $mb_email, $w);

    if ($w == '' && !$mb_password) {
        $list['msg'] = '비밀번호를 입력해주세요';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }

    if ($msg = empty_mb_name($mb_name)) {
        $list['msg'] = $msg;
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }
    if ($msg = reserve_mb_id($mb_id)) {
        $list['msg'] = $msg;
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }

    if ($w == '') {
        if ($msg = exist_mb_id($mb_id)) {
            $list['msg'] = $msg;
            $list['code'] = '9999';
            echo json_encode($list);
            exit;
        }
    }
}

// 사용자 코드 실행
@include_once($member_skin_path.'/register_form_update.head.skin.php');

if ($w == '') {
    $sql = " select mb_id from {$g5['member_table']} where mb_id = '{$mb_id}' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'] != '') {
        $list['msg'] = '입력하신 본인확인 정보로 가입된 내역이 존재합니다';
        $list['code'] = '9999';
        echo json_encode($list);
        exit;
    }

    $sql = " insert into {$g5['member_table']}
                set mb_id = '{$mb_id}',
                     mb_password = '".get_encrypt_string($mb_password)."',
                     mb_name = '{$mb_name}',
                     mb_nick = '{$mb_nick}',
                     mb_nick_date = '".G5_TIME_YMD."',
                     mb_hp = '{$mb_hp}',
                     mb_zip1 = '{$mb_zip1}',
                     mb_zip2 = '{$mb_zip2}',
                     mb_addr1 = '{$mb_addr1}',
                     mb_addr2 = '{$mb_addr2}',
                     mb_addr3 = '{$mb_addr3}',
                     mb_addr_jibeon = '{$mb_addr_jibeon}',
                     mb_area = '{$mb_area}',
                     mb_area_x = '{$mb_area_x}',
                     mb_area_y = '{$mb_area_y}',
                     mb_today_login = '".G5_TIME_YMDHIS."',
                     mb_datetime = '".G5_TIME_YMDHIS."',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_level = '{$set_level}',
                     mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_open_date = '".G5_TIME_YMD."',
                     
                     mb_menu = '',
                     security_number = '{$security_number}',
                     activity_status = '{$activity_status}',
                     enter_date = '{$enter_date}',
                     quit_date = '{$quit_date}',
                     mb_memo = '{$mb_memo}',
                     branch_id = '{$branch_id}'
                     {$sql_certify} ";

    // 이메일 인증을 사용하지 않는다면 이메일 인증시간을 바로 넣는다
    if (!$config['cf_use_email_certify'])
        $sql .= " , mb_email_certify = '".G5_TIME_YMDHIS."' ";
    if(sql_query($sql)) {

        $reg_date = date('Y-m-d H:i:s');

        /* 매니저 메뉴 관리 설정 STR */
        if(count($management) > 0) {
            for($i=0; $i<count($management); $i++) {
                $management_arr = explode('|', $management[$i]);
                $me_code1 = $management_arr[0];
                $me_code2 = $management_arr[1];
                $me_code3 = $management_arr[2];
                $me_code = $management_arr[2];
                $mode = $management_arr[3];
                $permit = $management_arr[4];

                $management_sql = " insert into g5_management 
                    set mb_id = '{$mb_id}', 
                    me_code1 = '{$me_code1}', 
                    me_code2 = '{$me_code2}', 
                    me_code3 = '{$me_code3}', 
                    me_code = '{$me_code}', 
                    mode = '{$mode}', 
                    permit = '{$permit}', 
                    reg_date = '{$reg_date}' ";
                sql_query($management_sql);
            }
        }
        /* 매니저 메뉴 관리 설정 END */

        $list['msg'] = '매니저등록이 완료되었습니다';
        $list['code'] = '0000';
        $list['mb_id'] = $mb_id;
    }
} else if ($w == 'u') {
    $sql_password = "";
    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";

    $sql = " update {$g5['member_table']}
        set mb_name = '{$mb_name}',
            mb_hp = '{$mb_hp}',
            mb_zip1 = '{$mb_zip1}',
            mb_zip2 = '{$mb_zip2}',
            mb_addr1 = '{$mb_addr1}',
            mb_addr2 = '{$mb_addr2}',
            mb_addr3 = '{$mb_addr3}',
            mb_addr_jibeon = '{$mb_addr_jibeon}',
            mb_area = '{$mb_area}',
            mb_area_x = '{$mb_area_x}',
            mb_area_y = '{$mb_area_y}',

            security_number = '{$security_number}',
            activity_status = '{$activity_status}',
            enter_date = '{$enter_date}',
            quit_date = '{$quit_date}',
            mb_memo = '{$mb_memo}',
            branch_id = '{$branch_id}'
            {$sql_password} 
            {$sql_certify} 
            where mb_id = '{$mb_id}' ";
    if(sql_query($sql)) {
        // 매니저 메뉴 관리 설정 초기화
        $management_del_sql = " delete from g5_management where mb_id = '{$mb_id}' ";
        sql_query($management_del_sql);

        $reg_date = date('Y-m-d H:i:s');

        /* 매니저 메뉴 관리 설정 STR */
        if(count($management) > 0) {
            for($i=0; $i<count($management); $i++) {
                $management_arr = explode('|', $management[$i]);
                $me_code1 = $management_arr[0];
                $me_code2 = $management_arr[1];
                $me_code3 = $management_arr[2];
                $me_code = $management_arr[2];
                $mode = $management_arr[3];
                $permit = $management_arr[4];

                $management_sql = " insert into g5_management 
                    set mb_id = '{$mb_id}', 
                    me_code1 = '{$me_code1}', 
                    me_code2 = '{$me_code2}', 
                    me_code3 = '{$me_code3}', 
                    me_code = '{$me_code}', 
                    mode = '{$mode}', 
                    permit = '{$permit}', 
                    reg_date = '{$reg_date}' ";
                sql_query($management_sql);
            }
        }
        /* 매니저 메뉴 관리 설정 END */

        $list['msg'] = '매니저수정이 완료되었습니다';
        $list['code'] = '0000';
        $list['mb_id'] = $mb_id;
    }
}

// 사용자 코드 실행
@include_once ($member_skin_path.'/register_form_update.tail.skin.php');

echo json_encode($list);
exit;