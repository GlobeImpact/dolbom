<?php
$mn_cd = 'sitemap';

include_once('./_common.php');

$g5['title'] = '전체 메뉴';

include_once('./_head.php');

$skin_file = G5_BBS_PATH.'/sitemap/sitemap.php';
include_once($skin_file);

include_once('./_tail.php');