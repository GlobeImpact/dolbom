<?php
$popup_tit = '';

$mb_id = $_GET['mb_id'];
$mode = $_GET['mode'];
switch($mode) {
    case 'enter':
        $popup_tit = '재직증명서';
    break;

    case 'career':
        $popup_tit = '경력증명서';
    break;

    case 'activity':
        $popup_tit = '활동증명서';
    break;

    case 'quit':
        $popup_tit = '퇴직확인원';
    break;

    default:
    break;
}
$popup_tit .= ' 옵션선택';

$sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$row = sql_fetch($sql);
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode ?>">
        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $mb_id ?>">

        <div class="layer_popup_form">
            <div class="form_tbl_wrap">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th class="x100">주민번호<span class="required_txt">*</span></th>
                            <td>
                                <div class="flex_row">
                                    <label class="input_label" for="security_number_set"><input type="checkbox" name="security_number_set" id="security_number_set" value="y" checked>주민번호 뒷자리 숨기기</label>
                                </div>
                                <p class="help_txt">※ 선택 해제시 주민번호 뒷자리까지 공개됩니다.</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="x100">담당업무<span class="required_txt">*</span></th>
                            <td>
                                <input type="text" name="service_category_set" id="service_category_set" class="form_input x100" value="<?php echo $row['service_category'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th class="x100">제출용도<span class="required_txt">*</span></th>
                            <td>
                            <input type="text" name="usage_set" id="usage_set" class="form_input x150" value="재직확인">
                            </td>
                        </tr>
                        <?php if($mode != 'activity' && $mode != 'quit') { ?>
                        <tr>
                            <th class="x100">제출처<span class="required_txt">*</span></th>
                            <td>
                            <input type="text" name="submit_to_set" id="submit_to_set" class="form_input x150" value="취업지원센터">
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <a class="submit_btn" id="certificate_submit_btn">설정완료</a>
</div>

<script>
let mb_profile;

$(function(){
    // 이미지 등록 버튼 클릭시 첨부파일 띄우기
    $('#profile_write_btn').click(function(){
        $('#mb_profile').click();
    });

    // 프로필 이미지 미리보기(Preview)
    $("#mb_profile").change(function(event){
        const file = event.target.files;
        imageFile = event.target.files[0];

        var image = new Image();
        var ImageTempUrl = window.URL.createObjectURL(file[0]);

        $("#profile_write_wrap > img").attr('src', ImageTempUrl);
    });

    $(".date_api").datepicker(datepicker_option);
});
</script>