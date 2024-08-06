<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_user_status.css?ver=1">', 0);

// 등록/수정 권한
$write_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'write' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $write_permit = false;
    }
}

// 삭제 권한
$delete_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'delete' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $delete_permit = false;
    }
}

$sch_service_cate = $_GET['sch_service_cate'];
$sch_str_receipt_date = $_GET['sch_str_receipt_date'];
$sch_end_receipt_date = $_GET['sch_end_receipt_date'];
$sch_cl_name = $_GET['sch_cl_name'];
$sch_cl_hp = $_GET['sch_cl_hp'];
?>

<input type="hidden" id="now_year" value="<?php echo $now_year ?>">

<div id="layer_wrap">
    <div id="layer_box">
        <!-- Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="filter_box">
                <select class="filter_select" id="sch_service_cate">
                    <option value="" <?php echo ($sch_service_cate == '')?'selected':''; ?>>서비스분류선택</option>
                    <?php
                    $service_menu_sql = " select * from g5_service_menu where client_menu = '{$_SESSION['this_code']}' and length(sme_code) = 2 and sme_use = 1 order by sme_code asc, sme_order asc ";
                    $service_menu_qry = sql_query($service_menu_sql);
                    $service_menu_num = sql_num_rows($service_menu_qry);
                    if($service_menu_num > 0) {
                        for($l=0; $service_menu_row = sql_fetch_array($service_menu_qry); $l++) {
                    ?>
                    <option value="<?php echo $service_menu_row['sme_code'] ?>" <?php echo ($sch_service_cate == $service_menu_row['sme_code'])?'selected':''; ?>><?php echo $service_menu_row['sme_name'] ?></option>
                    <?php
                        }
                    }
                    ?>
                    <?php if($_SESSION['this_code'] == '20') { ?><option value="10|20">바우처+유료</option><?php } ?>
                </select>
                <label>접수기간</label>
                <input type="text" class="filter_input_date date_api" id="sch_str_receipt_date" value="<?php echo $sch_str_receipt_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="접수기간"> ~ 
                <input type="text" class="filter_input_date date_api" id="sch_end_receipt_date" value="<?php echo $sch_end_receipt_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="접수기간">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_name" value="<?php echo $sch_cl_name ?>" placeholder="신청인">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_hp" value="<?php echo $sch_cl_hp ?>" oninput="autoHyphen(this)" maxlength="13" placeholder="연락처">
            </div>
        </div>
        <!-- Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl width_max">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>신청인</th>
                            <th>성별</th>
                            <th>나이</th>
                            <th>시작일자</th>
                            <th>주민등록번호</th>
                            <th>거주지</th>
                        </tr>
                    </thead>
                </table>

                <table class="layer_list_tbl width_max">
                    <tbody id="user_status_list">
                        <tr class="list_selected" client_idx="15" work_idx="1">
                            <td>1</td>
                            <td>김민우</td>
                            <td>여</td>
                            <td>40</td>
                            <td>2024-07-10</td>
                            <td>990909-1111111</td>
                            <td>부산 수영구</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->
    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
let write_ajax;

$(function(){
});

$(document).ready(function(){
});
</script>
