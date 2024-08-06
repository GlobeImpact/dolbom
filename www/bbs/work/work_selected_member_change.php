<?php
$idx = $_GET['idx'];
$work_idx = $_GET['work_idx'];
$selected_date = $_GET['selected_date'];

$popup_tit = '관리사 교체';

$sql = " select * from g5_work where idx = '{$work_idx}' ";
$row = sql_fetch($sql);

$now_mb_sql = " select * from g5_member where mb_id = '{$row['mb_id']}' ";
$now_mb_row = sql_fetch($now_mb_sql);

$work_sql = " select a.*, b.client_idx, b.client_service from g5_work_selected as a left join g5_work as b on b.idx = a.work_idx where a.work_idx = '{$work_idx}' and a.selected_date >= '".date('Y-m-d')."' order by a.selected_date asc ";
$work_qry = sql_query($work_sql);
$work_num = sql_num_rows($work_qry);

$yoil = array("일","월","화","수","목","금","토");
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="selected_member_change_form" name="selected_member_change_form" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="idx" id="idx" value="<?php echo $idx ?>">
        <input type="hidden" name="work_idx" id="work_idx" value="<?php echo $work_idx ?>">

        <div class="layer_popup_form">
            <div class="selected_member_change_wrap">
                <div><?php echo $now_mb_row['mb_name'] ?> (<?php echo substr($now_mb_row['security_number'], 0, 8) ?>)</div>
                <img src="<?php echo G5_IMG_URL ?>/arrow_change.png">
                <div>
                    <input type="hidden" name="change_mb_id" id="change_mb_id" value="">
                    <p id="change_mb_name_txt"></p>
                    <a id="selected_member_change_btn">파견사 선택</a>
                </div>
            </div>
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl selected_member_change_tbl">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="change_check_all" value=""></th>
                            <th>근태적용</th>
                            <th>요일</th>
                            <th>주말/공휴일</th>
                            <th>파견일</th>
                            <th>도우미</th>
                            <th>파견인원</th>
                            <th>바우처</th>
                            <th>유료</th>
                            <th>근무시간</th>
                        </tr>
                    </thead>
                </table>
                <table class="layer_list_tbl selected_member_change_tbl">
                    <tbody>
                        <?php
                        if($work_num > 0) {
                            for($i=0; $work_row = sql_fetch_array($work_qry); $i++) {
                                $holiday_sql = " select count(*) as cnt from g5_holiday where h_date = '{$work_row['selected_date']}' and is_holiday = 'Y' ";
                                $holiday_row = sql_fetch($holiday_sql);

                                $mb_sql = " select * from {$g5['member_table']} where mb_id = TRIM('".$work_row['mb_id']."') ";
                                $mb_row = sql_fetch($mb_sql);

                                $mb_name_txt = $mb_row['mb_name'];
                                if($mb_row['security_number'] != '') {
                                    $mb_name_txt .= ' (';
                                    $mb_name_txt .= wz_get_gender($mb_row['security_number']).'자';
                                    $mb_name_txt .= '·'.wz_get_age($mb_row['security_number']);
                                    $mb_name_txt .= ')';
                                }

                                $selected_date_mk = date('Ymd', $work_row['selected_date_mk']);
                        ?>
                        <tr <?php echo ($work_row['idx'] == $idx)?'class="member_select_list_selected"':''; ?>>
                            <td>
                                <input type="checkbox" name="change_check[]" id="change_check<?php echo $i ?>" class="change_check" value="<?php echo $work_row['idx'] ?>" <?php echo ($work_row['idx'] == $idx)?'checked':''; ?>>
                            </td>
                            <td></td>
                            <td><?php echo $yoil[date('w', strtotime($selected_date_mk))]; ?></td>
                            <td><?php echo (date('w', strtotime($selected_date_mk)) == 0 || date('w', strtotime($selected_date_mk)) == 6 || $holiday_row['cnt'] > 0)?'Y':'N'; ?></td>
                            <td><?php echo $work_row['selected_date'] ?></td>
                            <td><?php echo $mb_name_txt ?></td>
                            <td>1명</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <a class="submit_btn" id="selected_change_submit_btn">저장하기</a>
</div>

<?php
$client_idx = $row['client_idx'];
$client_service = $row['client_service'];

$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);

$area_x = $client_row['cl_area_x'];
$area_y = $client_row['cl_area_y'];

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and mb_level = 2 and mb_hide = '' and activity_status = '활동중' and service_category = '{$client_service}'";

if($area_x != '' && $area_y != '') {
    $orderby_str .= ", activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

    $sql = " select *, 
    ( 6371 * acos( cos( radians( $area_y ) ) * cos( radians( mb_area_y ) ) * cos( radians( mb_area_x ) - radians( $area_x ) ) + sin( radians( $area_y ) ) * sin( radians( mb_area_y ) ) ) ) AS distance
    from g5_member where (1=1) {$where_str} 
    HAVING distance < 100 
    order by distance asc {$orderby_str} ";
}else{
    $orderby_str .= "activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

    $sql = " select * from g5_member where (1=1) {$where_str} order by {$orderby_str} ";
}
$qry = sql_query($sql);
$num = sql_num_rows($qry);
?>
<div id="member_change_list_wrap">
    <div id="layer_popup_top">
        <h3>파견관리사 선택</h3>
        <a id="member_change_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
    </div>

    <div id="layer_popup_content">
        <form id="fregisterform" name="fregisterform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="client_idx" id="client_idx" value="<?php echo $client_idx ?>">

            <input type="hidden" id="now_year" value="<?php echo $now_year ?>">
            <input type="hidden" id="now_month" value="<?php echo $now_month ?>">

            <div class="layer_popup_form">
                <div class="layer_list_box">
                    <table class="layer_list_hd_tbl width_max" id="work_member_tbl_hd">
                        <thead>
                            <tr>
                                <th></th>
                                <th>현황</th>
                                <th>직원명</th>
                                <th>팀</th>
                                <th>연락처</th>
                                <th>생년월일</th>
                                <th>파견</th>
                                <th>반려동물</th>
                                <th>행정구역</th>
                                <th>특이사항</th>
                            </tr>
                        </thead>
                    </table>
                    <table class="layer_list_tbl width_max member_change_tbl" id="work_member_tbl">
                        <tbody>
                            <?php
                            if($num > 0) {
                                for($i=0; $row = sql_fetch_array($qry); $i++) {
                                    $mb_addr_arr = explode(' ', $row['mb_addr1']);
                                    $mb_addr = '';
                                    if($row['mb_addr1'] != '') $mb_addr = $mb_addr_arr[1];
                            ?>
                            <tr <?php echo ($row['mb_id'] == $mb_id)?'class="member_select_list_selected"':''; ?>>
                                <td>
                                    <input type="checkbox" name="select_mb_id[]" id="select_mb_id<?php echo $i ?>" class="member_select_check" value="<?php echo $row['mb_id'] ?>" mb_name="<?php echo $row['mb_name'] ?> (<?php echo substr($row['security_number'], 0, 8) ?>)" <?php echo ($row['mb_id'] == $mb_id)?'checked':''; ?>>
                                </td>
                                <td><?php echo $row['activity_status'] ?></td>
                                <td><?php echo $row['mb_name'] ?></td>
                                <td><?php echo $row['team_category'] ?></td>
                                <td><?php echo $row['mb_hp'] ?></td>
                                <td><?php echo wz_get_birth($row['security_number']) ?></td>
                                <td></td>
                                <td><?php echo $row['pet_use'] ?></td>
                                <td>
                                    <?php
                                    if($area_x != '' && $area_y != '') echo '['.round($row['distance'], 1).'km] ';
                                    echo $mb_addr;
                                    ?>
                                </td>
                                <td class="talign_l"><?php echo $row['mb_memo2'] ?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <a class="submit_btn" id="member_change_submit_btn">선택완료</a>
    </div>
</div>