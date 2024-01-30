<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/icode.lms.lib.php');

function lmsSend($sHp, $rHp, $msg, $booking_datetime) {
    global $g5, $config;
    $rtn = "";
    try {
        $send_hp = str_replace("-","",$sHp); // - 제거
        $recv_hp = str_replace("-","",$rHp); // - 제거
        $strDest = array();
        $strDest[0] = $recv_hp;
        $SMS = new LMS; // SMS 연결
        $SMS->SMS_con($config['cf_icode_server_ip'],
                                    $config['cf_icode_id'],
                                    $config['cf_icode_pw'],
                                    '1');
        $SMS->Add($strDest,
                            $send_hp,
                            $config['cf_icode_id'],
                            "",
                            "",
                            iconv("utf-8", "euc-kr", $msg),
                            "{$booking_datetime}",
                            "1");
        $result = $SMS->Send();

        $rtn = true;
    }
    catch(Exception $e) {
        $rtn = false;
    }
    return $rtn;
}

$list = Array();

// 로그인이 되어 있지 않을 경우 등록/수정 불가
if(!$is_member) {
    $list['msg'] = '로그인이 필요합니다.';
    $list['code'] = '9999';
    echo json_encode($list);
    exit;
}

$list = $_POST;

$booking = $_POST['booking'];
$booking_date = str_replace('-', '', $_POST['booking_date']);
$booking_time = str_replace(':', '', $_POST['booking_time']);
$booking_datetime = '';
if($booking == 'y') {
    $booking_datetime = $booking_date.''.$booking_time;
}
$send_message = $_POST['send_message'];
$send_list = $_POST['send_list'];
$send_hp = '051-505-2224';
if(count($send_list) > 0) {
    for($i=0; $i<count($send_list); $i++) {
        if($config['cf_sms_type'] == 'LMS') {
            if($send_list[$i]['recv_hp'] != '') {
                $user_category = $send_list[$i]['user_category'];
                $recv_id = $send_list[$i]['recv_id'];
                $recv_name = $send_list[$i]['recv_name'];
                $recv_hp = $send_list[$i]['recv_hp'];

                $send_result = lmsSend($send_hp, $recv_hp, $send_message, $booking_datetime);
                $sql = " insert into g5_sms_result set 
                    code_menu = '{$_SESSION['this_code']}', 
                    user_category = '{$user_category}', 
                    recv_id = '{$recv_id}', 
                    recv_name = '{$recv_name}', 
                    recv_hp = '{$recv_hp}', 
                    send_hp = '{$send_hp}', 
                    booking_datetime = '{$booking_datetime}', 
                    send_message = '{$send_message}', 
                    reg_date = '".date('Y-m-d H:i:s')."' ";
                sql_query($sql);
            }
        }
    }
}

$list['code'] = '0000';
$list['msg'] = '문자전송 결과는 문자전송내역에서 확인해주세요';

echo json_encode($list);
exit;
?>
