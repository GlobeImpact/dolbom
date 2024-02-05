<?php
$mn_cd = '10';

include_once('./_common.php');

$g5['title'] = '';

$mb_id = $_GET['mb_id'];
$mode = $_GET['mode'];
switch($mode) {
    case 'enter':
        $g5['title'] = '재직증명서';
    break;

    case 'career':
        $g5['title'] = '경력증명서';
    break;

    case 'activity':
        $g5['title'] = '활동증명서';
    break;

    case 'quit':
        $g5['title'] = '퇴직확인원';
    break;

    default:
    break;
}

include_once('./_head.sub.php');

$skin_file = G5_BBS_PATH.'/certificate/'.$mode.'.php';
include_once($skin_file);

include_once('./_tail.sub.php');