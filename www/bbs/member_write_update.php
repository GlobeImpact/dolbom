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

$mb_name        = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : '';
$mb_nick        = $mb_name;
$mb_email       = isset($_POST['mb_email']) ? trim($_POST['mb_email']) : '';
$mb_sex         = isset($_POST['mb_sex'])           ? trim($_POST['mb_sex'])         : "";
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
$mb_profile     = isset($_POST['mb_profile'])       ? trim($_POST['mb_profile'])     : "";
$mb_open        = isset($_POST['mb_open'])          ? trim($_POST['mb_open'])        : "0";

$security_number    = isset($_POST['security_number'])            ? trim($_POST['security_number'])          : "";
$activity_status    = isset($_POST['activity_status'])            ? trim($_POST['activity_status'])          : "";
$contract_type      = isset($_POST['contract_type'])              ? trim($_POST['contract_type'])            : "";
$premium_use        = isset($_POST['premium_use'])                ? trim($_POST['premium_use'])              : "";
$service_category   = isset($_POST['service_category'])           ? trim($_POST['service_category'])         : "";
$team_category      = isset($_POST['team_category'])              ? trim($_POST['team_category'])            : "";
$enter_date         = isset($_POST['enter_date'])                 ? trim($_POST['enter_date'])               : "";

$major4_insurance   = isset($_POST['major4_insurance'])           ? trim($_POST['major4_insurance'])         : "";
$loss_insurance     = isset($_POST['loss_insurance'])             ? trim($_POST['loss_insurance'])           : "";
$quit_date          = isset($_POST['quit_date'])                  ? trim($_POST['quit_date'])                : "";
$basic_price        = isset($_POST['basic_price'])                ? trim($_POST['basic_price'])              : "";
$monthly_income     = isset($_POST['monthly_income'])             ? trim($_POST['monthly_income'])           : "";

$bank_name          = isset($_POST['bank_name'])                  ? trim($_POST['bank_name'])                : "";
$bank_account       = isset($_POST['bank_account'])               ? trim($_POST['bank_account'])             : "";
$account_holder     = isset($_POST['account_holder'])             ? trim($_POST['account_holder'])           : "";
$account_holder_etc = isset($_POST['account_holder_etc'])         ? trim($_POST['account_holder_etc'])       : "";
$vulnerable         = isset($_POST['vulnerable'])                 ? trim($_POST['vulnerable'])               : "";
$vulnerable_etc     = isset($_POST['vulnerable_etc'])             ? trim($_POST['vulnerable_etc'])           : "";
$pet_use            = isset($_POST['pet_use'])                    ? trim($_POST['pet_use'])                  : "";
$mb_memo            = isset($_POST['mb_memo'])                    ? trim($_POST['mb_memo'])                  : "";
$mb_memo2           = isset($_POST['mb_memo2'])                   ? trim($_POST['mb_memo2'])                 : "";
$branch_id          = isset($_POST['branch_id'])                  ? trim($_POST['branch_id'])                : "";

$education_memo     = isset($_POST['education_memo'])             ? trim($_POST['education_memo'])           : "";
$career_memo        = isset($_POST['career_memo'])                ? trim($_POST['career_memo'])              : "";
$criminal_history   = isset($_POST['criminal_history'])           ? trim($_POST['criminal_history'])         : "";

$mb_name        = clean_xss_tags($mb_name);
$mb_tel         = clean_xss_tags($mb_tel);
$mb_zip1        = preg_replace('/[^0-9]/', '', $mb_zip1);
$mb_zip2        = preg_replace('/[^0-9]/', '', $mb_zip2);
$mb_addr1       = clean_xss_tags($mb_addr1);
$mb_addr2       = clean_xss_tags($mb_addr2);
$mb_addr3       = clean_xss_tags($mb_addr3);
$mb_addr_jibeon = preg_match("/^(N|R)$/", $mb_addr_jibeon) ? $mb_addr_jibeon : '';

if($mb_id == '') $mb_id = $security_number;

$mb_password    = isset($mb_id) ? trim($mb_id) : '';
$mb_password_re = isset($mb_id) ? trim($mb_id) : '';

if($activity_status == '활동중') {
    $quit_date = '';
}

if($quit_date != '') {
    $activity_status = '퇴사';
}

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

    if ($is_check_password){
        if ($w == '' && !$mb_password) {
            $list['msg'] = '비밀번호를 입력해주세요';
            $list['code'] = '9999';
            echo json_encode($list);
            exit;
        }
        if ($w == '' && $mb_password != $mb_password_re) {
            $list['msg'] = '비밀번호가 일치하지 않습니다';
            $list['code'] = '9999';
            echo json_encode($list);
            exit;
        }
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
    } else {
        // 회원정보의 메일을 이전 메일로 옮기고 아래에서 비교함
        $old_email = $member['mb_email'];
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
                     mb_signature = '{$mb_signature}',
                     mb_today_login = '".G5_TIME_YMDHIS."',
                     mb_datetime = '".G5_TIME_YMDHIS."',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_level = '{$config['cf_register_level']}',
                     mb_recommend = '{$mb_recommend}',
                     mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_open = '{$mb_open}',
                     mb_open_date = '".G5_TIME_YMD."',

                     mb_menu = '{$_SESSION['this_code']}',

                     security_number = '{$security_number}',
                     activity_status = '{$activity_status}',
                     contract_type = '{$contract_type}',
                     premium_use = '{$premium_use}',
                     service_category = '{$service_category}',
                     team_category = '{$team_category}',
                     enter_date = '{$enter_date}',

                     major4_insurance = '{$major4_insurance}',
                     loss_insurance = '{$loss_insurance}',
                     quit_date = '{$quit_date}',
                     basic_price = '{$basic_price}',
                     monthly_income = '{$monthly_income}',

                     bank_name = '{$bank_name}',
                     bank_account = '{$bank_account}',
                     account_holder = '{$account_holder}',
                     account_holder_etc = '{$account_holder_etc}',
                     vulnerable = '{$vulnerable}',
                     vulnerable_etc = '{$vulnerable_etc}',
                     pet_use = '{$pet_use}',
                     mb_memo = '{$mb_memo}',
                     mb_memo2 = '{$mb_memo2}',
                     branch_id = '{$branch_id}', 
                     education_memo = '{$education_memo}', 
                     career_memo = '{$career_memo}', 
                     criminal_history = '{$criminal_history}' 
                     {$sql_certify} ";

    // 이메일 인증을 사용하지 않는다면 이메일 인증시간을 바로 넣는다
    if (!$config['cf_use_email_certify'])
        $sql .= " , mb_email_certify = '".G5_TIME_YMDHIS."' ";
    if(sql_query($sql)) {

        if( $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height'] ){
            $mb_tmp_dir = G5_DATA_PATH.'/member_image/';
            $mb_dir = $mb_tmp_dir.substr($mb_id,0,2);
            if( !is_dir($mb_tmp_dir) ){
                @mkdir($mb_tmp_dir, G5_DIR_PERMISSION);
                @chmod($mb_tmp_dir, G5_DIR_PERMISSION);
            }

            // 회원 프로필 이미지 업로드
            $mb_profile = '';
            if (isset($_FILES['mb_profile'])) {
                if ($_FILES['mb_profile']['name'] != '') {
                    // 아이콘 용량이 설정값보다 이하만 업로드 가능
                    if ($_FILES['mb_profile']['size'] <= $config['cf_member_img_size']) {
                        @mkdir($mb_dir, G5_DIR_PERMISSION);
                        @chmod($mb_dir, G5_DIR_PERMISSION);

                        $exploded_file = explode(".", $_FILES['mb_profile']['name']);
                        $file_extension = array_pop($exploded_file);

                        $dest_path = $mb_dir.'/'.$mb_id.'.'.$file_extension;
                        move_uploaded_file($_FILES['mb_profile']['tmp_name'], $dest_path);
                        chmod($dest_path, G5_FILE_PERMISSION);
                        if (file_exists($dest_path)) {
                            $list['mb_profile'] = $dest_path;
                            $size = @getimagesize($dest_path);
                            if (!($size[2] === 1 || $size[2] === 2 || $size[2] === 3)) { // gif jpg png 파일이 아니면 올라간 이미지를 삭제한다.
                                @unlink($dest_path);
                            } else if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
                                $thumb = null;
                                if($size[2] === 2 || $size[2] === 3) {
                                    //jpg 또는 png 파일 적용
                                    $thumb = thumbnail($mb_id.'.'.$file_extension, $mb_dir, $mb_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);

                                    $profile_sql = " update g5_member set mb_profile = '".$mb_id.'.'.$file_extension."' where mb_id = '{$mb_id}' ";
                                    sql_query($profile_sql);

                                    if($thumb) {
                                        @unlink($dest_path);
                                        rename($mb_dir.'/'.$thumb, $dest_path);
                                    }
                                }
                                if( !$thumb ){
                                    // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                                    @unlink($dest_path);
                                }
                            }
                            //=================================================================\
                        }
                    } else {
                        $msg .= '회원이미지을 '.number_format($config['cf_member_img_size']).'바이트 이하로 업로드 해주십시오.';
                    }

                } else {
                    $msg .= $_FILES['mb_profile']['name'].'은(는) gif/jpg 파일이 아닙니다.';
                }
            }
        }

        $list['msg'] = '제공인력등록이 완료되었습니다';
        $list['code'] = '0000';
        $list['mb_id'] = $mb_id;
    }
} else if ($w == 'u') {
    $sql_password = "";
    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";

    $sql_nick_date = "";
    if ($mb_nick_default != $mb_nick)
        $sql_nick_date =  " , mb_nick_date = '".G5_TIME_YMD."' ";

    // 이전 메일주소와 수정한 메일주소가 틀리다면 인증을 다시 해야하므로 값을 삭제
    $sql_email_certify = '';
    if ($old_email != $mb_email && $config['cf_use_email_certify'])
        $sql_email_certify = " , mb_email_certify = '' ";

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
            contract_type = '{$contract_type}',
            premium_use = '{$premium_use}',
            service_category = '{$service_category}',
            team_category = '{$team_category}',
            enter_date = '{$enter_date}',

            major4_insurance = '{$major4_insurance}',
            loss_insurance = '{$loss_insurance}',
            quit_date = '{$quit_date}',
            basic_price = '{$basic_price}',
            monthly_income = '{$monthly_income}',

            bank_name = '{$bank_name}',
            bank_account = '{$bank_account}',
            account_holder = '{$account_holder}',
            account_holder_etc = '{$account_holder_etc}',
            vulnerable = '{$vulnerable}',
            vulnerable_etc = '{$vulnerable_etc}',
            pet_use = '{$pet_use}',
            mb_memo = '{$mb_memo}',
            mb_memo2 = '{$mb_memo2}',
            branch_id = '{$branch_id}', 
            education_memo = '{$education_memo}', 
            career_memo = '{$career_memo}', 
            criminal_history = '{$criminal_history}' 
            {$sql_password} 
            {$sql_certify} 
            where mb_id = '{$mb_id}' ";
    sql_query($sql);

    $mb_tmp_dir = G5_DATA_PATH.'/member_image/';
    $mb_dir = $mb_tmp_dir.substr($mb_id,0,2);
    if( !is_dir($mb_tmp_dir) ){
        @mkdir($mb_tmp_dir, G5_DIR_PERMISSION);
        @chmod($mb_tmp_dir, G5_DIR_PERMISSION);
    }

    if($_POST['mb_profile_del'] == 'y' && $_POST['prev_mb_profile'] != '') {
        @unlink($mb_dir.'/'.$_POST['prev_mb_profile']);

        $profile_del_sql = " update g5_member set mb_profile = '' where mb_id = '{$mb_id}' ";
        sql_query($profile_del_sql);
    }

    if( $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height'] ){
        // 회원 프로필 이미지 업로드
        $mb_profile = '';
        if (isset($_FILES['mb_profile'])) {
            if ($_FILES['mb_profile']['name'] != '') {
                // 아이콘 용량이 설정값보다 이하만 업로드 가능
                if ($_FILES['mb_profile']['size'] <= $config['cf_member_img_size']) {
                    @mkdir($mb_dir, G5_DIR_PERMISSION);
                    @chmod($mb_dir, G5_DIR_PERMISSION);

                    $exploded_file = explode(".", $_FILES['mb_profile']['name']);
                    $file_extension = array_pop($exploded_file);

                    $dest_path = $mb_dir.'/'.$mb_id.'.'.$file_extension;
                    move_uploaded_file($_FILES['mb_profile']['tmp_name'], $dest_path);
                    chmod($dest_path, G5_FILE_PERMISSION);
                    if (file_exists($dest_path)) {
                        $list['mb_profile'] = $dest_path;
                        $size = @getimagesize($dest_path);
                        if (!($size[2] === 1 || $size[2] === 2 || $size[2] === 3)) { // gif jpg png 파일이 아니면 올라간 이미지를 삭제한다.
                            @unlink($dest_path);
                        } else if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
                            $thumb = null;
                            if($size[2] === 2 || $size[2] === 3) {
                                //jpg 또는 png 파일 적용
                                $thumb = thumbnail($mb_id.'.'.$file_extension, $mb_dir, $mb_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);

                                $profile_sql = " update g5_member set mb_profile = '".$mb_id.'.'.$file_extension."' where mb_id = '{$mb_id}' ";
                                sql_query($profile_sql);

                                if($thumb) {
                                    @unlink($dest_path);
                                    rename($mb_dir.'/'.$thumb, $dest_path);
                                }
                            }
                            if( !$thumb ){
                                // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                                @unlink($dest_path);
                            }
                        }
                        //=================================================================\
                    }
                } else {
                    $msg .= '회원이미지을 '.number_format($config['cf_member_img_size']).'바이트 이하로 업로드 해주십시오.';
                }

            } else {
                $msg .= $_FILES['mb_profile']['name'].'은(는) gif/jpg 파일이 아닙니다.';
            }
        }
    }

    $list['msg'] = '제공인력수정이 완료되었습니다';
    $list['code'] = '0000';
    $list['mb_id'] = $mb_id;
}

// 사용자 코드 실행
@include_once ($member_skin_path.'/register_form_update.tail.skin.php');

echo json_encode($list);
exit;