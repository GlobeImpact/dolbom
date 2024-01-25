<?php
$w = $_GET['w'];
$set_idx = $_GET['set_idx'];
$rent_idx = $_GET['rent_idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$set_sql = " select * from g5_client_rental_set where set_idx = '{$set_idx}' ";
$set_row = sql_fetch($set_sql);

$popup_tit = $set_row['set_tit'].' 대여등록';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 대여수정';

if($w == '') {
    $write['rent_date'] = $now_year.'-'.date('m-d');
}

if($w == 'u' && $rent_idx != '') {
    $sql = " select * from g5_client_rental where rent_idx = '{$rent_idx}' ";
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
        <input type="hidden" name="rent_idx" id="rent_idx" value="<?php echo $rent_idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">

        <div class="layer_popup_form">
            <h4 class="layer_popup_tit"><?php echo $set_row['set_tit'] ?></h4>
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <th>대여품 번호</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_numb" id="rent_numb" class="form_input x150" value="<?php echo $write['rent_numb'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">대여기간<span class="required_txt">*</span></th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_date" id="rent_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['rent_date'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">대여자<span class="required_txt">*</span></th>
                        <td>
                            <div class="td_flex_row">
                                <input type="hidden" name="rent_mb_id" id="rent_mb_id" value="<?php echo $write['rent_mb_id'] ?>">
                                <input type="text" name="rent_name" id="rent_name" class="form_input x80" value="<?php echo $write['rent_name'] ?>">
                                <a id="mb_select_btn">대여자선택</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">반납기간</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_return_date" id="rent_return_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['rent_return_date'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">반납자</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="hidden" name="rent_return_mb_id" id="rent_return_mb_id" class="form_input x80" value="<?php echo $write['rent_return_mb_id'] ?>">
                                <input type="text" name="rent_return_name" id="rent_return_name" class="form_input x80" value="<?php echo $write['rent_return_name'] ?>">
                                <a id="mb_select_btn2">반납자선택</a>
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