<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

/* 가사서비스 || 아가마지 구분 STR */
$this_code = $_GET['this_code'];
if($is_admin) {
    if($this_code) {
        $_SESSION['this_code'] = $this_code;
    }else{
        $_SESSION['this_code'] = 10;
    }
}else if($member['mb_level'] == 5) {
    if($this_code) {
        $_SESSION['this_code'] = $this_code;
    }else{
        $management_sql = " select distinct(me_code1) from g5_management where mb_id = '{$member['mb_id']}' and mode = 'view' order by me_code asc limit 0, 1 ";
        $management_row = sql_fetch($management_sql);
        $_SESSION['this_code'] = $management_row['me_code1'];
    }
}else{
    $_SESSION['this_code'] = $member['mb_menu'];
}
/* 가사서비스 || 아가마지 구분 END */

/* 지점 구분 STR */
if($is_admin) {
    if($_SESSION['this_branch_id'] == '') {
        $branch_sql = " select * from g5_branch where branch_hide = '' order by branch_id asc limit 0, 1 ";
        $branch_row = sql_fetch($branch_sql);
        $_SESSION['this_branch_id'] = $branch_row['branch_id'];
        $_SESSION['this_branch_name'] = $branch_row['branch_name'];
        $this_branch_id = $_SESSION['this_branch_id'];
    }else{
        $this_branch_id = $_SESSION['this_branch_id'];
    }
}else if($member['mb_level'] == 5) {
    $branch_sql = " select * from g5_branch where branch_hide = '' and branch_id = '{$member['branch_id']}' ";
    $branch_row = sql_fetch($branch_sql);
    $_SESSION['this_branch_id'] = $member['branch_id'];
    $_SESSION['this_branch_name'] = $branch_row['branch_name'];
    $this_branch_id = $_SESSION['this_branch_id'];
}else{
    $branch_sql = " select * from g5_branch where branch_hide = '' and branch_id = '{$member['branch_id']}' ";
    $branch_row = sql_fetch($branch_sql);
    $_SESSION['this_branch_id'] = $member['branch_id'];
    $_SESSION['this_branch_name'] = $branch_row['branch_name'];
    $this_branch_id = $_SESSION['this_branch_id'];
}
/* 지점 구분 END */

/* 접근 페이지 3차 카테고리 세션 등록 STR */
if($mn_cd_sub != '') {
    $mn_cd_full = $_SESSION['this_code'].''.$mn_cd_sub;
}
if($mn_cd_full != '' && !$_SESSION['this_mn_cd_full']) {
    $_SESSION['this_mn_cd_full'] = $mn_cd_full;
}
/* 접근 페이지 3차 카테고리 세션 등록 END */

/* 매니저 View 접근 권한 설정 STR */
if($member['mb_level'] == 5) {
    $permit_code = $_SESSION['this_code'].''.$mn_cd_sub;
    if(mb_strlen($permit_code) == 6) {
        $view_permit_sql = " select count(*) as cnt from g5_management where mb_id = '{$member['mb_id']}' and mode = 'view' and me_code = '{$permit_code}' ";
        $view_permit_row = sql_fetch($view_permit_sql);
        if($view_permit_row['cnt'] == 0) {
            alert('해당 매니저는 접속시도한 페이지에 허용되지 않았습니다.', G5_URL);
            exit;
        }
    }
}
/* 매니저 View 접근 권한 설정 END */

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    // 상태바에 표시될 제목
    $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/

if(!$is_member && !$login_page) {
    goto_url(G5_BBS_URL.'/login.php');
}
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" id="meta_viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<?php
$shop_css = '';
if (defined('_SHOP_')) $shop_css = '_shop';
echo '<link rel="stylesheet" href="'.run_replace('head_css_url', G5_THEME_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css?ver=5'.G5_CSS_VER, G5_THEME_URL).'">'.PHP_EOL;
?>
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php if (defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
var g5_theme_shop_url = "<?php echo G5_THEME_SHOP_URL; ?>";
var g5_shop_url = "<?php echo G5_SHOP_URL; ?>";
<?php } ?>
<?php if(defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>
</script>
<?php
add_javascript('<script src="'.G5_JS_URL.'/jquery-1.12.4.min.js"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery-migrate-1.4.1.min.js"></script>', 0);
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
        add_javascript('<script src="'.G5_JS_URL.'/jquery.shop.menu.js?ver='.G5_JS_VER.'"></script>', 0);
    }
} else {
    add_javascript('<script src="'.G5_JS_URL.'/jquery.menu.js?ver='.G5_JS_VER.'"></script>', 0);
}
add_javascript('<script src="'.G5_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/wrest.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/placeholders.min.js"></script>', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/font-awesome/css/font-awesome.min.css">', 0);

if(G5_IS_MOBILE) {
    add_javascript('<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>', 1); // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}