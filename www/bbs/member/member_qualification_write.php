<?php
$w = $_GET['w'];
$set_idx = $_GET['set_idx'];
$mb_id = $_GET['mb_id'];
$idx = $_GET['idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$set_sql = " select * from g5_member_qualification_set where set_idx = '{$set_idx}' ";
$set_row = sql_fetch($set_sql);

$mb_sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$mb_row = sql_fetch($mb_sql);

$popup_tit = $set_row['set_tit'].' 작성';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 수정';

if($w == '') {
    $write['diagnosis_date'] = '';
    $write['judgment_date'] = '';
    $write['confirm_date'] = '';
}

if($w == 'u' && $idx != '') {
    $sql = " select * from g5_member_qualification where idx = '{$idx}' ";
    $write = sql_fetch($sql);

    if($write['diagnosis_date'] == '0000-00-00') $write['diagnosis_date'] = '';
    if($write['judgment_date'] == '0000-00-00') $write['judgment_date'] = '';
    if($write['confirm_date'] == '0000-00-00') $write['confirm_date'] = '';
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
        <input type="hidden" name="idx" id="idx" value="<?php echo $idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $mb_id ?>">

        <div class="layer_popup_form">
            <h4 class="layer_popup_tit"><?php echo $set_row['set_tit'] ?></h4>
            <table class="form_tbl">
                <tbody>
                    <tr>
                        <th>직원명</th>
                        <td><div class="td_flex_row"><?php echo $mb_row['mb_name'] ?></div></td>
                    </tr>
                    <tr>
                        <th class="x100">진단일자</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="diagnosis_date" id="diagnosis_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['diagnosis_date'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">판정일자</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="judgment_date" id="judgment_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['judgment_date'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">확인일자</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="confirm_date" id="confirm_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['confirm_date'] ?>">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>

<script>
$(function(){
    $(".date_api").datepicker(datepicker_option);
});
</script>