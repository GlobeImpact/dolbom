<?php
$sub_menu = "100290";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 이전 메뉴정보 삭제
$sql = " delete from {$g5['menu_table']} ";
sql_query($sql);

$group_code = null;
$primary_code = null;
$second_code = null;
$count = count($_POST['code']);

for ($i=0; $i<$count; $i++)
{
    $_POST = array_map_deep('trim', $_POST);

    if(preg_match('/^javascript/i', preg_replace('/[ ]{1,}|[\t]/', '', $_POST['me_link'][$i]))){
        $_POST['me_link'][$i] = G5_URL;
    }

    $_POST['me_link'][$i] = is_array($_POST['me_link']) ? clean_xss_tags(clean_xss_attributes(preg_replace('/[ ]{2,}|[\t]/', '', $_POST['me_link'][$i]), 1)) : '';

    $code    = is_array($_POST['code']) ? strip_tags(substr($_POST['code'][$i],0,2)) : '';
    $sub	 = is_array($_POST['sub']) ? strip_tags($_POST['sub'][$i]) : '';
	$me_name = is_array($_POST['me_name']) ? strip_tags($_POST['me_name'][$i]) : '';
    $me_link = (preg_match('/^javascript/i', $_POST['me_link'][$i]) || preg_match('/script:/i', $_POST['me_link'][$i])) ? G5_URL : strip_tags(clean_xss_attributes($_POST['me_link'][$i]));
	$me_pid    = is_array($_POST['me_pid']) ? strip_tags($_POST['me_pid'][$i]) : '';

    if(!$code || !$me_name || !$me_link)
        continue;

	// 메뉴코드
    $sub_code = '';
	if($group_code == $code) {
		if($sub) {
			$sql = " select MAX(SUBSTRING(me_code,3,2)) as max_me_code
						from {$g5['menu_table']}
						where SUBSTRING(me_code,1,2) = '$primary_code' ";
			$row = sql_fetch($sql);

			$sub_code = base_convert($row['max_me_code'], 36, 10);
			$sub_code += 36;
			$sub_code = base_convert($sub_code, 10, 36);

			$me_code = $primary_code.$sub_code;
			$second_code = $me_code;
		} else {
			$sql = " select MAX(SUBSTRING(me_code,5,2)) as max_me_code
						from {$g5['menu_table']}
						where SUBSTRING(me_code,1,4) = '$second_code' ";
			$row = sql_fetch($sql);

			$sub_code = base_convert($row['max_me_code'], 36, 10);
			$sub_code += 36;
			$sub_code = base_convert($sub_code, 10, 36);

			$me_code = $second_code.$sub_code;
		}
	} else {
        $sql = " select MAX(SUBSTRING(me_code,1,2)) as max_me_code
                    from {$g5['menu_table']}
                    where LENGTH(me_code) = '2' ";
        $row = sql_fetch($sql);

        $me_code = base_convert($row['max_me_code'], 36, 10);
        $me_code += 36;
        $me_code = base_convert($me_code, 10, 36);

        $group_code = $code;
        $primary_code = $me_code;
    }

    // 메뉴 등록
    $sql = " insert into {$g5['menu_table']}
                set me_code         = '".$me_code."',
                    me_name         = '".$me_name."',
                    me_link         = '".$me_link."',
                    me_pid          = '".$me_pid."',
                    me_target       = '".sql_real_escape_string(strip_tags($_POST['me_target'][$i]))."',
                    me_order        = '".sql_real_escape_string(strip_tags($_POST['me_order'][$i]))."',
                    me_use          = '".sql_real_escape_string(strip_tags($_POST['me_use'][$i]))."',
                    me_mobile_use   = '".sql_real_escape_string(strip_tags($_POST['me_mobile_use'][$i]))."' ";
    sql_query($sql);
}

run_event('admin_menu_list_update');

goto_url('./menu_list.php');