<?php
$w = $_GET['w'];
$set_idx = $_GET['set_idx'];
$mb_id = $_GET['mb_id'];
$heal_idx = $_GET['heal_idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$set_sql = " select * from g5_member_health_set where set_idx = '{$set_idx}' ";
$set_row = sql_fetch($set_sql);

$mb_sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$mb_row = sql_fetch($mb_sql);

$popup_tit = $set_row['set_tit'].' 작성';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 수정';

if($w == '') {
    $write['heal_date'] = $now_year.'-'.date('m-d');
}

if($w == 'u' && $heal_idx != '') {
    $sql = " select * from g5_member_health where heal_idx = '{$heal_idx}' ";
    $write = sql_fetch($sql);
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="set_idx" id="set_idx" value="<?php echo $set_idx ?>">
        <input type="hidden" name="heal_idx" id="heal_idx" value="<?php echo $heal_idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $mb_id ?>">

        <div class="layer_popup_form">
            <h4 class="layer_popup_tit"><?php echo $set_row['set_tit'] ?></h4>
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <th>직원명</th>
                        <td><div class="td_flex_row"><?php echo $mb_row['mb_name'] ?></div></td>
                    </tr>
                    <tr>
                        <th class="x100">검진일시<span class="required_txt">*</span></th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="heal_date" id="heal_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['heal_date'] ?>">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>

<div id="write_layer_popup_bg"></div>
<div id="write_layer_popup"></div>

<script>
$(function(){
    $(".date_api").datepicker(datepicker_option);
});
</script>