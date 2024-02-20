<?php
$idx = $_GET['idx'];

$sql = " select * from g5_member_education where idx = '{$idx}' ";
$view = sql_fetch($sql);

$set_sql = " select * from g5_member_education_set where set_idx = '{$view['set_idx']}' ";
$set_row = sql_fetch($set_sql);

$popup_tit = $set_row['set_tit'].' 조회';

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
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <div class="layer_popup_form">
        <h4 class="layer_popup_tit"><?php echo $view['edu_tit'] ?></h4>
        <div class="form_tbl_wrap view_wrap">
            <table class="form_tbl">
                <tbody>
                    <tr>
                        <th class="x100">교육일시</th>
                        <td class="x420">
                            <div class="flex_row">
                                <span>
                                <?php
                                echo $view['edu_date'].' '.$view['edu_str_hour'].':'.$view['edu_str_min'].' ~ '.$view['edu_end_hour'].':'.$view['edu_end_min'];
                                ?>
                                </span>
                                <?php if($write_permit === true) { ?>
                                <a class="view_edit_btn" id="edit_btn" idx="<?php echo $idx ?>" set_idx="<?php echo $set_row['set_idx'] ?>">수정</a>
                                <?php } ?>
                                <?php if($delete_permit === true) { ?>
                                <a class="view_del_btn" id="del_btn" idx="<?php echo $idx ?>">삭제</a>
                                <?php } ?>
                            </div>
                        </td>
                        <th class="x100" rowspan="5">교육내용</th>
                        <td class="h477" rowspan="5">
                            <div class="view_tbl_memo hp100"><?php echo nl2br($view['edu_content']) ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>교육제목</th>
                        <td><?php echo $view['edu_tit'] ?></td>
                    </tr>
                    <tr>
                        <th>교육방법</th>
                        <td>
                            <div class="flex_row"><?php echo $view['edu_method'] ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>교육기관</th>
                        <td>
                            <div class="flex_row"><?php echo $view['edu_agency'] ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th class="h333">참석자</th>
                        <td class="h333 valign_top">
                            <div class="mb_select_list_box">
                                <?php
                                $edul_view_sql = " select b.mb_name, b.service_category from g5_member_education_list as a left join g5_member as b on b.mb_id = a.edul_mb_id where a.idx = '{$idx}' and b.mb_hide = '' ";
                                $edul_view_qry = sql_query($edul_view_sql);
                                $edul_view_num = sql_num_rows($edul_view_qry);
                                
                                if($edul_view_num > 0) {
                                    for($i=0; $edul_view_row = sql_fetch_array($edul_view_qry); $i++) {
                                ?>
                                <a class="mb_select_list not_delete"><span><?php echo $edul_view_row['mb_name'] ?></span><span>(<?php echo $edul_view_row['service_category'] ?>)</span></a>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="write_layer_popup_bg"></div>
<div id="write_layer_popup"></div>
