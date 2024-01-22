<?php
$w = $_GET['w'];
$set_idx = $_GET['set_idx'];

$popup_tit = '교육 리스트 추가';
if($w == 'u') $popup_tit = '교육 리스트 수정';

if($w == 'u' && $set_idx != '') {
    $sql = " select * from g5_member_education_set where set_idx = '{$set_idx}' ";
    $write = sql_fetch($sql);
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="set_fregisterform" name="set_fregisterform" action="" onsubmit="return set_fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="set_idx" id="set_idx" value="<?php echo $set_idx ?>">

        <div class="layer_popup_form">
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <th>교육명<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="set_tit" id="set_tit" class="form_input x300" value="<?php echo $write['set_tit'] ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    <a class="submit_btn" id="set_submit_btn">저장하기</a>
</div>
