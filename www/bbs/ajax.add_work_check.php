<?php
include_once('./_common.php');

$now_date = date('Ymd');

$client_idx = $_POST['client_idx'];
$mb_id = $_POST['mb_id'];

$list = Array();

$list['msg'] = '실패하였습니다';
$list['code'] = '9999';

// 고객 체크
$sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$row = sql_fetch($sql);

if($row['client_idx'] == '') {
    $list['msg'] = '고객 정보가 없습니다.';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['receipt_date'] == '' || $row['receipt_date'] == '0000-00-00') {
    $list['msg'] = '고객접수관리 페이지에서 접수일자를 설정해주세요';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['cancel_date'] != '0000-00-00') {
    $list['msg'] = '접수가 취소된 고객입니다.';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['end_date'] != '0000-00-00' && $now_date > str_replace('-', '', $row['end_date'])) {
    $list['msg'] = '종료된 고객입니다.';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['cl_addr1'] == '') {
    $list['msg'] = '고객접수관리 페이지에서 주소를 설정해주세요';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['cl_service_cate'] == '') {
    $list['msg'] = '고객접수 서비스정보의 서비스 구분을 설정해주세요';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['cl_service_cate2'] == '') {
    $list['msg'] = '고객접수 서비스정보의 서비스 구분을 설정해주세요';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

if($row['cl_service_period'] == '') {
    $list['msg'] = '고객접수 서비스정보의 서비스 기간을 설정해주세요';
    $list['code'] = '9999';
    
    echo json_encode($list);
    exit;
}

$list['msg'] = 'Clear';
$list['code'] = '0000';

echo json_encode($list);