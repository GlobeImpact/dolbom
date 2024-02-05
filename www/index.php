<?php
include_once('./_common.php');

if($is_admin) {
    include_once('./bbs/member.php');
}else{
    $index_sql = " select distinct(a.me_code), a.* from g5_menu as a left join g5_management as b on b.me_code = a.me_code where b.mb_id = '{$member['mb_id']}' and mode = 'view' order by a.me_order asc, a.me_code asc limit 0,1 ";
    $index_row = sql_fetch($index_sql);
    $index_path = '';
    if($index_row['me_link'] != '') {
        $index_path .= '.'.$index_row['me_link'];
    }else{
        $index_path .= './bbs/sitemap.php';
    }
    include_once($index_path);
    exit;
}
?>