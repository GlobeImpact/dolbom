<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/theme/basic/css/default.css?ver=2">', 0);

$w = $_GET['w'];
$idx = $_GET['idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$popup_tit = $set_row['set_tit'].' 민원등록';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 민원수정';

if($w == '') {
    $write['comp_date'] = $now_year.'-'.date('m-d');
}

if($w == 'u' && $idx != '') {
    $sql = " select * from g5_client_complaints where idx = '{$idx}' ";
    $write = sql_fetch($sql);

    if($write['comp_date'] == '0000-00-00') $write['comp_date'] = '';
    if($write['take_date'] == '0000-00-00') $write['take_date'] = '';
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="idx" id="idx" value="<?php echo $idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" name="comp_date" id="comp_date" value="<?php echo $write['comp_date'] ?>">

        <div class="layer_popup_form">
            <div class="form_tbl_wrap">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th class="x120">상담구분<span class="required_txt">*</span></th>
                            <td class="x390">
                                <select name="comp_category" id="comp_category" class="form_select x140">
                                    <option value="">상담구분 선택</option>
                                    <?php for($l=0; $l<count($set_comp_category_arr); $l++) { ?>
                                        <option value="<?php echo $set_comp_category_arr[$l] ?>" <?php echo ($set_comp_category_arr[$l] == $write['comp_category'])?'selected':''; ?>><?php echo $set_comp_category_arr[$l] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <th class="x120">조치구분</th>
                            <td>
                                <select name="take_category" id="take_category" class="form_select x140">
                                    <option value="">조치구분 선택</option>
                                    <?php for($l=0; $l<count($set_take_category_arr); $l++) { ?>
                                        <option value="<?php echo $set_take_category_arr[$l] ?>" <?php echo ($set_take_category_arr[$l] == $write['take_category'])?'selected':''; ?>><?php echo $set_take_category_arr[$l] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>고객선택<span class="required_txt">*</span></th>
                            <td>
                                <input type="hidden" name="comp_client_idx" id="comp_client_idx" value="<?php echo $write['comp_client_idx'] ?>">
                                <input type="text" name="comp_client_name" id="comp_client_name" class="form_input x100" value="<?php echo $write['comp_client_name'] ?>" readonly>
                                <a class="form_btn1" id="form_select_btn">고객선택</a>
                            </td>
                            <th>조치일자</th>
                            <td>
                                <input type="text" name="take_date" id="take_date" class="form_input_date date_api" value="<?php echo $write['take_date'] ?>" oninput="autoHyphen3(this);" maxlength="10">
                            </td>
                        </tr>
                        <tr>
                            <th>상담내용</th>
                            <td>
                                <textarea name="comp_content" id="comp_content" class="form_textarea y180"><?php echo $write['comp_content'] ?></textarea>
                            </td>
                            <th>조치내용</th>
                            <td>
                                <textarea name="take_content" id="take_content" class="form_textarea y180"><?php echo $write['take_content'] ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="3">
                                    <textarea name="take_etc" id="take_etc" class="form_textarea y100"><?php echo $write['take_etc'] ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>

<div id="select_layer_popup_bg"></div>
<div id="select_layer_popup" class="x500"></div>

<script>
$(function(){
    $(".date_api").datepicker(datepicker_option);
});
</script>