<?php
$w = $_GET['w'];
$mb_id = $_GET['mb_id'];

$popup_tit = '매니저등록';
if($w == 'u') $popup_tit = '매니저수정';

if($w == 'u' && $mb_id != '') {
    $sql = " select * from g5_member where mb_id = '{$mb_id}' and mb_hide = '' and mb_level = '5' ";
    $write = sql_fetch($sql);

    if($write['enter_date'] == '0000-00-00') $write['enter_date'] = '';
    if($write['quit_date'] == '0000-00-00') $write['quit_date'] = '';
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="prev_mb_id" value="<?php echo $mb_id ?>">

        <div class="layer_popup_form">
            <h4 class="layer_popup_form_tit">매니저 기본정보</h4>
            <div class="form_tbl_wrap">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th>지점<span class="required_txt">*</span></th>
                            <td colspan="7">
                            <select name="branch_id" id="branch_id" class="form_select x140">
                                    <option value="">지점 선택</option>
                                    <?php
                                    $branch_sql = " select * from g5_branch where branch_hide = '' order by branch_name asc ";
                                    $branch_qry = sql_query($branch_sql);
                                    $branch_num = sql_num_rows($branch_qry);
                                    if($branch_num > 0) {
                                        for($i=0; $branch_row = sql_fetch_array($branch_qry); $i++) {
                                    ?>
                                    <option value="<?php echo $branch_row['branch_id'] ?>" <?php echo ($branch_row['branch_id'] == $write['branch_id'])?'selected':''; ?>><?php echo $branch_row['branch_name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="x90">성명<span class="required_txt">*</span></th>
                            <td class="x160">
                                <input type="text" name="mb_name" id="mb_name" class="form_input x100" value="<?php echo $write['mb_name'] ?>">
                            </td>
                            <th class="x90">연락처<span class="required_txt">*</span></th>
                            <td class="x160">
                                <input type="text" name="mb_hp" id="mb_hp" class="form_input x100" value="<?php echo $write['mb_hp'] ?>" oninput="autoHyphen(this)" maxlength="13">
                            </td>
                            <th class="x90">주민번호</th>
                            <td class="x160">
                                <input type="text" name="security_number" id="security_number" class="form_input x120" value="<?php echo $write['security_number'] ?>" oninput="autoHyphen2(this)" maxlength="14">
                            </td>
                            <th class="x90">활동현황<span class="required_txt">*</span></th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select x100">
                                    <?php for($l=0; $l<count($set_mn_activity_status_arr); $l++) { ?>
                                    <option value="<?php echo $set_mn_activity_status_arr[$l] ?>" <?php echo ($set_mn_activity_status_arr[$l] == $write['activity_status'])?'selected':''; ?>><?php echo $set_mn_activity_status_arr[$l] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>아이디<span class="required_txt">*</span></th>
                            <td>
                                <input type="text" name="mb_id" id="mb_id" class="form_input x100" value="<?php echo $write['mb_id'] ?>" <?php echo ($w == 'u')?'readonly':''; ?>>
                            </td>
                            <th>비밀번호<?php if($w == '') { ?><span class="required_txt">*</span><?php } ?></th>
                            <td>
                                <input type="password" name="mb_password" id="mb_password" class="form_input x100" value="">
                            </td>
                            <th>입사일자<span class="required_txt">*</span></th>
                            <td>
                                <input type="text" name="enter_date" id="enter_date" class="form_input_date date_api" value="<?php echo $write['enter_date'] ?>" oninput="autoHyphen3(this);" maxlength="10">
                            </td>
                            <th>퇴사일자</th>
                            <td>
                                <input type="text" name="quit_date" id="quit_date" class="form_input_date date_api" value="<?php echo $write['quit_date'] ?>" oninput="autoHyphen3(this);" maxlength="10">
                            </td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td colspan="7">
                                <div class="flex_row_addr">
                                    <input type="text" name="mb_zip" value="<?php echo $write['mb_zip1'].''.$write['mb_zip2'] ?>" id="reg_mb_zip" class="form_input" size="5" maxlength="6" placeholder="우편번호">
                                    <button type="button" class="form_btn1" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>
                                    <input type="text" name="mb_addr1" value="<?php echo $write['mb_addr1'] ?>" id="reg_mb_addr1" class="form_input frm_address full_input" placeholder="기본주소">
                                    <input type="text" name="mb_addr2" value="<?php echo $write['mb_addr2'] ?>" id="reg_mb_addr2" class="form_input frm_address full_input" placeholder="상세주소">
                                </div>

                                <input type="hidden" name="mb_addr3" value="<?php echo $write['mb_addr3'] ?>" id="reg_mb_addr3">
                                <input type="hidden" name="mb_addr_jibeon" value="<?php echo $write['mb_addr_jibeon'] ?>">

                                <input type="hidden" name="mb_area" id="mb_area" value="<?php echo $write['mb_area'] ?>">
                                <input type="hidden" name="mb_area_x" id="mb_area_x" value="<?php echo $write['mb_area_x'] ?>">
                                <input type="hidden" name="mb_area_y" id="mb_area_y" value="<?php echo $write['mb_area_y'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="7">
                                <textarea name="mb_memo" id="mb_memo" class="form_textarea y100"><?php echo $write['mb_memo'] ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h4 class="layer_popup_form_tit mtop20">매니저 담당정보</h4>

            <?php
            $management_cnt = 0;

            $me_code1_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 2 and me_use = 1 order by me_order asc, me_code asc ";
            $me_code1_qry = sql_query($me_code1_sql);
            $me_code1_num = sql_num_rows($me_code1_qry);
            if($me_code1_num > 0) {
                for($i=0; $me_code1_row = sql_fetch_array($me_code1_qry); $i++) {
                    $me_code2_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 4 and me_code like '{$me_code1_row['me_code']}%' and me_use = 1 order by me_order asc, me_code asc ";
                    $me_code2_qry = sql_query($me_code2_sql);
                    $me_code2_num = sql_num_rows($me_code2_qry);
            ?>
            <h4 class="management_tit"><?php echo $me_code1_row['me_name'] ?></h4>
                <?php
                if($me_code2_num > 0) {
                ?>
                <div class="form_tbl_wrap">
                    <table class="form_tbl management_tbl">
                        <tbody>
                            <?php
                            for($j=0; $me_code2_row = sql_fetch_array($me_code2_qry); $j++) {
                                $me_code3_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 6 and me_code like '{$me_code2_row['me_code']}%' and me_use = 1 order by me_order asc, me_code asc ";
                                $me_code3_qry = sql_query($me_code3_sql);
                                $me_code3_num = sql_num_rows($me_code3_qry);

                                $rowspan = '';
                                if($me_code3_num > 1) $rowspan = 'rowspan="'.$me_code3_num.'"';

                                if($me_code3_num > 0) {
                                    for($k=0; $me_code3_row = sql_fetch_array($me_code3_qry); $k++) {
                            ?>
                                    <tr>
                                        <?php if($k == 0) { ?><th class="x120" <?php echo $rowspan ?>><?php echo $me_code2_row['me_name'] ?></th><?php } ?>
                                        <td class="x140"><?php echo $me_code3_row['me_name'] ?></td>
                                        <td>
                                            <ul class="management_box">
                                                <?php
                                                foreach($set_management_mode_arr as $key => $value) {
                                                    if($w == 'u' && $mb_id != '') {
                                                        $management_sql = " select count(*) as cnt from g5_management where mb_id = '{$mb_id}' and me_code = '{$me_code3_row['me_code']}' and mode = '{$key}' ";
                                                        $management_row = sql_fetch($management_sql);
                                                    }
                                                ?>
                                                <li class="management_list">
                                                    <input type="checkbox" name="management[]" class="management_checkbox" id="management_<?php echo $management_cnt ?>" value="<?php echo $me_code1_row['me_code'] ?>|<?php echo $me_code2_row['me_code'] ?>|<?php echo $me_code3_row['me_code'] ?>|<?php echo $key ?>|y" <?php echo ($management_row['cnt'] > 0)?'checked':''; ?>>
                                                    <label for="management_<?php echo $management_cnt ?>"><?php echo $value ?> 허용</label>
                                                </li> 
                                                <?php
                                                    $management_cnt++;
                                                }
                                                ?>
                                            </ul>
                                        </td>
                                    </tr>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                }
                ?>
            <?php
                }
            }
            ?>
            <?/*
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <td rowspan="6" class="x150 vtop">
                            <div id="profile_write_wrap">
                                <input type="checkbox" name="mb_profile_del" id="mb_profile_del" value="y">
                                <input type="file" name="mb_profile" id="mb_profile" class="form_hide" accept="image/*">
                                <img src="<?php echo $profile_dir ?>" onerror="this.src='<?php echo G5_IMG_URL ?>/profile_noimg.png';">
                                <div id="profile_btn_box">
                                    <a id="profile_write_btn">이미지 등록</a>
                                    <a id="profile_delete_btn">이미지 삭제</a>
                                </div>
                            </div>
                        </td>
                        <th class="x110">서비스구분<span class="required_txt">*</span></th>
                        <td class="x220">
                            <select name="service_category" id="service_category" class="form_select">
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) { ?>
                                <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>" <?php echo ($write['service_category'] == ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l])?'selected':''; ?>><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></option>
                                <?php } ?>
                            </select>
                        </td>

                        <th class="x110">성명<span class="required_txt">*</span></th>
                        <td class="x200">
                            <input type="text" name="mb_name" id="mb_name" class="form_input x130" value="<?php echo $write['mb_name'] ?>">
                        </td>
                        <th class="x110">연락처<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="mb_hp" id="mb_hp" class="form_input x130" value="<?php echo $write['mb_hp'] ?>" oninput="autoHyphen(this)" maxlength="13">
                        </td>
                    </tr>
                    <tr>
                        <th>주민번호<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="security_number" id="security_number" class="form_input x130" value="<?php echo $write['security_number'] ?>" oninput="autoHyphen2(this)" maxlength="14">
                        </td>
                        <th>활동현황<span class="required_txt">*</span></th>
                        <td>
                            <select name="activity_status" id="activity_status" class="form_select">
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}); $l++) { ?>
                                    <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?>" <?php echo ($write['activity_status'] == ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l])?'selected':''; ?>><?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <th>계약형태<span class="required_txt">*</span></th>
                        <td>
                            <div class="label_flex">
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}); $l++) { ?>
                                    <label class="input_label" for="contract_type<?php echo $l ?>"><input type="radio" name="contract_type" class="contract_type" id="contract_type<?php echo $l ?>" value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}[$l] ?>" <?php echo ($write['contract_type'] == ${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}[$l])?'checked':''; ?>><?php echo ${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}[$l] ?></label>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>팀구분<span class="required_txt">*</span></th>
                        <td>
                            <select name="team_category" id="team_category" class="form_select">
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_team_category_arr'}); $l++) { ?>
                                <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_team_category_arr'}[$l] ?>" <?php echo ($write['team_category'] == ${'set_mn'.$_SESSION['this_code'].'_team_category_arr'}[$l])?'selected':''; ?>><?php echo ${'set_mn'.$_SESSION['this_code'].'_team_category_arr'}[$l] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <th>프리미엄</th>
                        <td>
                            <label class="input_label" for="premium_use"><input type="checkbox" name="premium_use" id="premium_use" value="y" <?php echo ($write['premium_use'] == 'y')?'checked':''; ?>>프리미엄</label>
                        </td>
                        <th>입사일자<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="enter_date" id="enter_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['enter_date'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>취약계층여부</th>
                        <td>
                            <select name="vulnerable" id="vulnerable" class="form_select">
                                <option value="">해당없음</option>
                                <?php for($l=0; $l<count($set_vulnerable_arr); $l++) { ?>
                                <option value="<?php echo $set_vulnerable_arr[$l] ?>" <?php echo ($write['vulnerable'] == $set_vulnerable_arr[$l])?'selected':''; ?>><?php echo $set_vulnerable_arr[$l] ?></option>
                                <?php } ?>
                            </select>
                            <input type="text" name="vulnerable_etc" id="vulnerable_etc" class="form_input x110" value="<?php echo $write['vulnerable_etc'] ?>">
                        </td>
                        <th>반려동물유무</th>
                        <td colspan="3">
                            <select name="pet_use" id="pet_use" class="form_select">
                                <?php for($l=0; $l<count($set_pet_use_arr); $l++) { ?>
                                <option value="<?php echo $set_pet_use_arr[$l] ?>" <?php echo ($write['pet_use'] == $set_pet_use_arr[$l])?'selected':''; ?>><?php echo $set_pet_use_arr[$l] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>주소</th>
                        <td colspan="5">
                            <div class="div_flex">
                                <input type="text" name="mb_zip" value="<?php echo $write['mb_zip1'].''.$write['mb_zip2'] ?>" id="reg_mb_zip" class="form_input" size="5" maxlength="6" placeholder="우편번호">
                                <button type="button" class="btn_frm_addr" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>

                                <input type="text" name="mb_addr1" value="<?php echo $write['mb_addr1'] ?>" id="reg_mb_addr1" class="form_input frm_address full_input" placeholder="기본주소">
                                <input type="text" name="mb_addr2" value="<?php echo $write['mb_addr2'] ?>" id="reg_mb_addr2" class="form_input frm_address full_input" placeholder="상세주소">
                                <input type="hidden" name="mb_addr3" value="<?php echo $write['mb_addr3'] ?>" id="reg_mb_addr3">
                                <input type="hidden" name="mb_addr_jibeon" value="<?php echo $write['mb_addr_jibeon'] ?>">

                                <input type="hidden" name="mb_area" id="mb_area" value="<?php echo $write['mb_area'] ?>">
                                <input type="hidden" name="mb_area_x" id="mb_area_x" value="<?php echo $write['mb_area_x'] ?>">
                                <input type="hidden" name="mb_area_y" id="mb_area_y" value="<?php echo $write['mb_area_y'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>비고</th>
                        <td colspan="5">
                            <textarea name="mb_memo" id="mb_memo" class="form_textarea"><?php echo $write['mb_memo'] ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="form_flex mtop20">
                <div class="div60 xp100">
                    <h4 class="layer_popup_tit mtop_20">매니저 급여정보</h4>

                    <table class="write_tbl">
                        <tbody>
                            <tr>
                                <th class="x110">4대보험가입</th>
                                <td class="x150">
                                    <input type="text" name="major4_insurance" id="major4_insurance" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['major4_insurance'] ?>">
                                </td>
                                <th class="x110">보험상실</th>
                                <td class="x150">
                                    <input type="text" name="loss_insurance" id="loss_insurance" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['loss_insurance'] ?>">
                                </td>
                                <th class="x110">퇴사일자</th>
                                <td colspan="3">
                                    <input type="text" name="quit_date" id="quit_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['quit_date'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>급여<span class="required_txt">*</span></th>
                                <td>
                                    <input type="text" name="basic_price" id="basic_price" class="form_input x80" oninput="inputNum(this.id)" value="<?php echo $write['basic_price'] ?>">
                                </td>
                                <th>표준월소득액<span class="required_txt">*</span></th>
                                <td colspan="5">
                                    <input type="text" name="monthly_income" id="monthly_income" class="form_input x130" oninput="inputNum(this.id)" value="<?php echo $write['monthly_income'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>은행</th>
                                <td>
                                    <select name="bank_name" id="bank_name" class="form_select">
                                        <option value="">은행선택</option>
                                        <?php for($l=0; $l<count($set_bank_name_arr); $l++) { ?>
                                        <option value="<?php echo $set_bank_name_arr[$l] ?>" <?php echo ($write['bank_name'] == $set_bank_name_arr[$l])?'selected':''; ?>><?php echo $set_bank_name_arr[$l] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <th>계좌번호</th>
                                <td>
                                    <input type="text" name="bank_account" id="bank_account" class="form_input x130" value="<?php echo $write['bank_account'] ?>">
                                </td>
                                <th>예금주</th>
                                <td>
                                    <input type="text" name="account_holder" id="account_holder" class="form_input xp100" value="<?php echo $write['account_holder'] ?>">
                                </td>
                                <th>예금주(기타)</th>
                                <td>
                                    <input type="text" name="account_holder_etc" id="account_holder_etc" class="form_input x130" value="<?php echo $write['account_holder_etc'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>특이사항</th>
                                <td colspan="7">
                                    <textarea name="mb_memo2" id="mb_memo2" class="form_textarea"><?php echo $write['mb_memo2'] ?></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            */?>
        </div>
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
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