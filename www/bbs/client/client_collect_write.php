<?php
$w = $_GET['w'];
$client_idx = $_GET['client_idx'];
$client_service = $_GET['client_service'];

$popup_tit = '고객접수등록';
if($w == 'u') $popup_tit = '고객접수수정';

if($w == '') {
    $write['client_service'] = $client_service;
    $write['branch_id'] = $_SESSION['this_branch_id'];
    $write['receipt_date'] = date('Y-m-d');
}

if($w == 'u' && $client_idx != '') {
    $sql = " select * from g5_client where client_idx = '{$client_idx}' ";
    $write = sql_fetch($sql);

    if($write['receipt_date'] == '0000-00-00') $write['receipt_date'] = '';
    if($write['str_date'] == '0000-00-00') $write['str_date'] = '';
    if($write['end_date'] == '0000-00-00') $write['end_date'] = '';
    if($write['cancel_date'] == '0000-00-00') $write['cancel_date'] = '';

    if($write['cl_birth_due_date'] == '0000-00-00') $write['cl_birth_due_date'] = '';
    if($write['cl_birth_date'] == '0000-00-00') $write['cl_birth_date'] = '';

    $client_service = $write['client_service'];
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <?php if($w == '' && $client_service == '') { ?>
        <div id="client_service_wrap">
            <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) { ?>
            <div class="client_service_box">
                <a class="client_service_list" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>">
                    <img src="<?php echo G5_IMG_URL.'/'.${'set_mn'.$_SESSION['this_code'].'_service_category_img_arr'}[$l].'.png' ?>" alt="<?php  echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>">
                    <p><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></p>
                </a>
            </div>
            <?php } ?>
        </div>
    <?php } ?>

    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="client_idx" id="client_idx" value="<?php echo $client_idx ?>">
        <input type="hidden" name="client_service" id="client_service" value="<?php echo $client_service ?>">
        <div class="layer_popup_form">
            <h4 class="layer_popup_form_tit">고객접수 기본정보</h4>
            <div class="form_tbl_wrap">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th>지점<span class="required_txt">*</span></th>
                            <td>
                                <select name="branch_id" id="branch_id" class="form_select x105">
                                    <option value="">지점 선택</option>
                                    <?php
                                    $branch_sql = " select * from g5_branch where branch_hide = '' order by branch_name asc, branch_id desc ";
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
                            <th>추천경로</th>
                            <td>
                                <select name="cl_recommended" id="cl_recommended" class="form_select">
                                    <option value="">추천경로선택</option>
                                    <option value="보건소" <?php echo ($write['cl_recommended'] == '보건소')?'selected':''; ?>>보건소</option>
                                    <option value="지인추천" <?php echo ($write['cl_recommended'] == '지인추천')?'selected':''; ?>>지인추천</option>
                                    <option value="홍보물" <?php echo ($write['cl_recommended'] == '홍보물')?'selected':''; ?>>홍보물</option>
                                    <option value="인터넷" <?php echo ($write['cl_recommended'] == '인터넷')?'selected':''; ?>>인터넷</option>
                                    <option value="일등맘 산모교실" <?php echo ($write['cl_recommended'] == '일등맘 산모교실')?'selected':''; ?>>일등맘 산모교실</option>
                                    <option value="첫째 때 이용" <?php echo ($write['cl_recommended'] == '첫째 때 이용')?'selected':''; ?>>첫째 때 이용</option>
                                    <option value="여성병원 홍보" <?php echo ($write['cl_recommended'] == '여성병원 홍보')?'selected':''; ?>>여성병원 홍보</option>
                                    <option value="기타" <?php echo ($write['cl_recommended'] == '기타')?'selected':''; ?>>기타</option>
                                </select>
                                <input type="text" name="cl_recommended_etc" id="cl_recommended_etc" class="form_input x165" value="<?php echo $write['cl_recommended_etc'] ?>" placeholder="추천경로 직접입력" <?php echo ($write['cl_recommended'] == '기타')?'style="display:inline-block;"':''; ?>>
                            </td>
                            <th>프뢰벨</th>
                            <td colspan="3">
                                <div class="flex_row">
                                    <label class="input_label" for="cl_froebel_agree1">
                                        <input type="radio" name="cl_froebel_agree" id="cl_froebel_agree1" value="y" <?php echo ($write['cl_froebel_agree'] == 'y')?'checked':''; ?>> 동의
                                    </label>

                                    <label class="input_label" for="cl_froebel_agree2">
                                        <input type="radio" name="cl_froebel_agree" id="cl_froebel_agree2" value="n" <?php echo ($write['cl_froebel_agree'] == 'n')?'checked':''; ?>> 미동의
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="x90">접수일자<span class="required_txt">*</span></th>
                            <td class="x165">
                                <input type="text" name="receipt_date" id="receipt_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['receipt_date'] ?>">
                            </td>
                            <th class="x90">시작일자</th>
                            <td class="x165">
                                <input type="text" name="str_date" id="str_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['str_date'] ?>">
                            </td>
                            <th class="x90">종료일자</th>
                            <td class="x165">
                                <input type="text" name="end_date" id="end_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['end_date'] ?>">
                            </td>
                            <th class="x90">취소일자</th>
                            <td>
                                <input type="text" name="cancel_date" id="cancel_date" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cancel_date'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>신청인<span class="required_txt">*</span></th>
                            <td>
                                <input type="text" name="cl_name" id="cl_name" class="form_input x105" value="<?php echo $write['cl_name'] ?>">
                            </td>
                            <th>주민번호</th>
                            <td>
                                <input type="text" name="cl_security_number" id="cl_security_number" class="form_input x105" value="<?php echo $write['cl_security_number'] ?>" oninput="autoHyphen2(this)" maxlength="14">
                            </td>
                            <th>연락처<span class="required_txt">*</span></th>
                            <td>
                                <input type="text" name="cl_hp" id="cl_hp" class="form_input x105" value="<?php echo $write['cl_hp'] ?>" oninput="autoHyphen(this)" maxlength="13">
                            </td>
                            <th>긴급연락처</th>
                            <td>
                                <input type="text" name="cl_tel" id="cl_tel" class="form_input x105" value="<?php echo $write['cl_tel'] ?>" oninput="autoHyphen(this)" maxlength="13">
                            </td>
                        </tr>
                        <tr class="client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0] ?>">
                            <th>가족관계</th>
                            <td>
                                <input type="text" name="cl_relationship" id="cl_relationship" class="form_input x105" value="<?php echo $write['cl_relationship'] ?>">
                            </td>
                            <th>아기이름</th>
                            <td>
                                <input type="text" name="cl_baby_name" id="cl_baby_name" class="form_input x105" value="<?php echo $write['cl_baby_name'] ?>">
                            </td>
                            <th>아기생년월일</th>
                            <td colspan="3">
                                <input type="text" name="cl_baby_birth" id="cl_baby_birth" class="form_input_date date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_baby_birth'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td colspan="7">
                                <div class="flex_row_addr">
                                    <input type="text" name="cl_zip" id="cl_zip" class="form_input" size="5" maxlength="6" placeholder="우편번호" value="<?php echo $write['cl_zip'] ?>">
                                    <button type="button" class="form_btn1" onclick="win_zip('fregisterform', 'cl_zip', 'cl_addr1', 'cl_addr2', 'cl_addr3', 'cl_addr_jibeon');">주소 검색</button>
                                    <input type="text" name="cl_addr1" id="cl_addr1" class="form_input frm_address full_input" placeholder="기본주소" value="<?php echo $write['cl_addr1'] ?>">
                                    <input type="text" name="cl_addr2" id="cl_addr2" class="form_input frm_address full_input" placeholder="상세주소" value="<?php echo $write['cl_addr2'] ?>">
                                    <input type="hidden" name="cl_addr3" id="cl_addr3" value="<?php echo $write['cl_addr3'] ?>">
                                    <input type="hidden" name="cl_addr_jibeon" id="cl_addr_jibeon" value="<?php echo $write['cl_addr_jibeon'] ?>">

                                    <input type="hidden" name="cl_area" id="cl_area" value="<?php echo $write['cl_area'] ?>">
                                    <input type="hidden" name="cl_area_x" id="cl_area_x" value="<?php echo $write['cl_area_x'] ?>">
                                    <input type="hidden" name="cl_area_y" id="cl_area_y" value="<?php echo $write['cl_area_y'] ?>">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form_tbl_wrap" style="margin-top:-2px; border-top:0;">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th>서비스구분</th>
                            <td colspan="5">
                                <select name="cl_service_cate" id="cl_service_cate" class="form_select price_input">
                                    <?/*<option value="" <?php echo ($write['cl_service_cate'] == '')?'selected':''; ?>>서비스분류선택</option>*/?>
                                    <?php
                                    $service_menu_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 2 and sme_use = 1 order by sme_order asc, sme_code asc ";
                                    $service_menu_qry = sql_query($service_menu_sql);
                                    $service_menu_num = sql_num_rows($service_menu_qry);
                                    if($service_menu_num > 0) {
                                        for($l=0; $service_menu_row = sql_fetch_array($service_menu_qry); $l++) {
                                    ?>
                                    <option value="<?php echo $service_menu_row['sme_code'] ?>" <?php echo ($write['cl_service_cate'] == $service_menu_row['sme_code'])?'selected':''; ?>><?php echo $service_menu_row['sme_name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <select name="cl_service_cate2" id="cl_service_cate2" class="form_select price_input">
                                    <option value="" <?php echo ($write['cl_service_cate2'] == '')?'selected':''; ?>>서비스구분선택</option>
                                    <?php
                                    $menu_group_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 4 and sme_code like '{$write['cl_service_cate']}%' and sme_use = 1 order by sme_order asc, sme_code asc ";
                                    $menu_group_qry = sql_query($menu_group_sql);
                                    $menu_group_num = sql_num_rows($menu_group_qry);
                                    if($menu_group_num > 0) {
                                        for($l=0; $menu_group_row = sql_fetch_array($menu_group_qry); $l++) {
                                    ?>
                                    <optgroup label="<?php echo $menu_group_row['sme_name'] ?>">
                                        <?php
                                        $service_menu2_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_code like '{$menu_group_row['sme_code']}%' and sme_use = 1 order by sme_order asc, sme_code asc ";
                                        $service_menu2_qry = sql_query($service_menu2_sql);
                                        $service_menu2_num = sql_num_rows($service_menu2_qry);
                                        if($service_menu2_num > 0) {
                                            for($ll=0; $service_menu2_row = sql_fetch_array($service_menu2_qry); $ll++) {
                                        ?>
                                        <option value="<?php echo $service_menu2_row['sme_id'] ?>" <?php echo ($write['cl_service_cate2'] == $service_menu2_row['sme_id'])?'selected':''; ?>><?php echo $service_menu2_row['sme_name'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </optgroup>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>서비스기간</th>
                            <td <?php echo ($write['client_service'] == '청소')?'':'colspan="3"'; ?>>
                                <?php
                                $service_period_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where sme_id = '{$write['cl_service_cate2']}' and client_service = '{$client_service}' order by spe_period_hour asc ";
                                $service_period_qry = sql_query($service_period_sql);
                                $service_period_num = sql_num_rows($service_period_qry);
                                ?>
                                <select name="cl_service_period" id="cl_service_period" class="form_select price_input">
                                    <?php if($client_service != '반찬') { ?><option value="">서비스기간선택</option><?php } ?>
                                    <?php
                                    if($service_period_num > 0) {
                                        for($l=0; $service_period_row = sql_fetch_array($service_period_qry); $l++) {
                                    ?>
                                    <option value="<?php echo $service_period_row['spe_id'] ?>" <?php echo ($write['cl_service_period'] == $service_period_row['spe_id'])?'selected':''; ?>><?php echo $service_period_row['spe_cate'] ?>(<?php echo $service_period_row['spe_name'] ?>)</option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <?php if($write['client_service'] == '청소') { ?>
                            <th>추가옵션</th>
                            <td>
                                <?php
                                $service_option_sql = " select * from g5_service_option where client_service = '{$client_service}' and (sop_cate = 'service') and sop_use = 1 order by sop_id asc ";
                                $service_option_qry = sql_query($service_option_sql);
                                $service_option_num = sql_num_rows($service_option_qry);
                                ?>
                                <select name="cl_service_option" id="cl_service_option" class="form_select price_input">
                                    <option value="">추가옵션선택</option>
                                    <?php
                                    if($service_option_num > 0) {
                                        for($l=0; $service_option_row = sql_fetch_array($service_option_qry); $l++) {
                                    ?>
                                    <option value="<?php echo $service_option_row['sop_id'] ?>" <?php echo ($write['cl_service_option'] == $service_option_row['sop_id'])?'selected':''; ?>><?php echo $service_option_row['sop_name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <?php } ?>
                            <th>지정관리사</th>
                            <td>
                                <select name="cl_work_select_mb_id" id="cl_work_select_mb_id" class="form_select">
                                    <option value="">지정관리사선택</option>
                                    <?php
                                    $wmb_sql = " select * from g5_member where mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and mb_level = 2 and mb_hide = '' and service_category = '{$client_service}' and activity_status = '활동중' order by activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc ";
                                    $wmb_qry = sql_query($wmb_sql);
                                    $wmb_num = sql_num_rows($wmb_qry);
                                    if($wmb_num > 0) {
                                        for($l=0; $wmb_row = sql_fetch_array($wmb_qry); $l++) {
                                    ?>
                                        <option value="<?php echo $wmb_row['mb_id'] ?>" <?php echo ($write['cl_work_select_mb_id'] == $wmb_row['mb_id'])?'selected':''; ?>><?php echo $wmb_row['mb_name'] ?> (<?php echo substr($wmb_row['security_number'], 0, 8) ?>) <?php echo $wmb_row['mb_hp'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <?php if($write['client_service'] == '베이비시터') { ?>
                        <tr>
                            <th>출산순위<span class="required_txt">*</span></th>
                            <td>
                                <select name="cl_baby_count" id="cl_baby_count" class="form_select">
                                    <option value="" <?php echo ($write['cl_baby_count'] == '')?'selected':''; ?>>출산순위선택</option>
                                    <option value="첫째" <?php echo ($write['cl_baby_count'] == '첫째')?'selected':''; ?>>첫째</option>
                                    <option value="둘째" <?php echo ($write['cl_baby_count'] == '둘째')?'selected':''; ?>>둘째</option>
                                    <option value="셋째" <?php echo ($write['cl_baby_count'] == '셋째')?'selected':''; ?>>셋째</option>
                                    <option value="넷째" <?php echo ($write['cl_baby_count'] == '넷째')?'selected':''; ?>>넷째</option>
                                    <option value="다섯째" <?php echo ($write['cl_baby_count'] == '다섯째')?'selected':''; ?>>다섯째</option>
                                </select>
                            </td>
                            <th>쌍둥이유무</th>
                            <td>
                                <select name="cl_twins" id="cl_twins" class="form_select price_input">
                                    <option value="" <?php echo ($write['cl_twins'] == '')?'selected':''; ?>>쌍둥이유무선택</option>
                                    <option value="n" <?php echo ($write['cl_twins'] == 'n')?'selected':''; ?>>없음</option>
                                    <option value="y" <?php echo ($write['cl_twins'] == 'y')?'selected':''; ?>>있음</option>
                                </select>
                            </td>
                            <th>큰아이유무</th>
                            <td>
                                <select name="cl_baby_first" id="cl_baby_first" class="form_select price_input">
                                    <option value="" <?php echo ($write['cl_baby_first'] == '')?'selected':''; ?>>큰아이유무선택</option>
                                    <option value="n" <?php echo ($write['cl_baby_first'] == 'n')?'selected':''; ?>>없음</option>
                                    <option value="y" <?php echo ($write['cl_baby_first'] == 'y')?'selected':''; ?>>있음</option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if($write['client_service'] == '베이비시터') { ?>
                        <tr>
                            <th>추가요금부담</th>
                            <td>
                                <select name="cl_surcharge" id="cl_surcharge" class="form_select">
                                    <option value="불가능" <?php echo ($write['cl_surcharge'] == '불가능')?'selected':''; ?>>불가능</option>
                                    <option value="가능" <?php echo ($write['cl_surcharge'] == '가능')?'selected':''; ?>>가능</option>
                                </select>
                            </td>
                            <th>연장근무</th>
                            <td colspan="3">
                                <?php
                                $overtime_sql = " select * from g5_service_option where client_service = '{$write['client_service']}' and sop_cate = 'overtime' and sop_use = 1 ";
                                $overtime_qry = sql_query($overtime_sql);
                                $overtime_num = sql_num_rows($overtime_qry);
                                ?>
                                <select name="cl_overtime" id="cl_overtime" class="form_select price_input">
                                    <option value="">연장근무선택</option>
                                    <option value="n" <?php echo ($write['cl_overtime'] == 'n')?'selected':''; ?>>없음</option>
                                    <option value="y" <?php echo ($write['cl_overtime'] == 'y')?'selected':''; ?>>있음</option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if($write['client_service'] == '청소') { ?>
                        <tr>
                            <th>추가요금부담</th>
                            <td>
                                <select name="cl_surcharge" id="cl_surcharge" class="form_select">
                                    <option value="불가능" <?php echo ($write['cl_surcharge'] == '불가능')?'selected':''; ?>>불가능</option>
                                    <option value="가능" <?php echo ($write['cl_surcharge'] == '가능')?'selected':''; ?>>가능</option>
                                </select>
                            </td>
                            <th>연장근무</th>
                            <td colspan="3">
                                <?php
                                $overtime_sql = " select * from g5_service_option where client_service = '{$write['client_service']}' and sop_cate = 'overtime' and sop_use = 1 ";
                                $overtime_qry = sql_query($overtime_sql);
                                $overtime_num = sql_num_rows($overtime_qry);
                                ?>
                                <select name="cl_overtime" id="cl_overtime" class="form_select price_input">
                                    <option value="">연장근무선택</option>
                                    <option value="n" <?php echo ($write['cl_overtime'] == 'n')?'selected':''; ?>>없음</option>
                                    <option value="y" <?php echo ($write['cl_overtime'] == 'y')?'selected':''; ?>>있음</option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if($write['client_service'] == '반찬') { ?>
                        <tr>
                            <th>추가요금부담</th>
                            <td colspan="5">
                                <select name="cl_surcharge" id="cl_surcharge" class="form_select">
                                    <option value="불가능" <?php echo ($write['cl_surcharge'] == '불가능')?'selected':''; ?>>불가능</option>
                                    <option value="가능" <?php echo ($write['cl_surcharge'] == '가능')?'selected':''; ?>>가능</option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <th>CCTV</th>
                            <td>
                                <select name="cl_cctv" id="cl_cctv" class="form_select">
                                    <option value="" <?php echo ($write['cl_cctv'] == '')?'selected':''; ?>>없음</option>
                                    <option value="y" <?php echo ($write['cl_cctv'] == 'y')?'selected':''; ?>>있음</option>
                                </select>
                            </td>
                            <th>반려동물</th>
                            <td>
                                <div class="flex_row">
                                    <label class="input_label" for="cl_pet_dog">
                                        <input type="checkbox" name="cl_pet_dog" class="cl_pet_dog" id="cl_pet_dog" value="y" <?php echo ($write['cl_pet_dog'] == 'y')?'checked':''; ?>> 애완견
                                    </label>
                                    <select name="cl_pet_dog_cnt" id="cl_pet_dog_cnt" class="form_select mr_10">
                                        <option value="" <?php echo ($write['cl_pet_dog_cnt'] == '')?'selected':''; ?>>선택</option>
                                        <option value="1" <?php echo ($write['cl_pet_dog_cnt'] == '1')?'selected':''; ?>>1마리</option>
                                        <option value="2" <?php echo ($write['cl_pet_dog_cnt'] == '2')?'selected':''; ?>>2마리</option>
                                        <option value="3" <?php echo ($write['cl_pet_dog_cnt'] == '3')?'selected':''; ?>>3마리</option>
                                        <option value="4" <?php echo ($write['cl_pet_dog_cnt'] == '4')?'selected':''; ?>>4마리</option>
                                        <option value="5" <?php echo ($write['cl_pet_dog_cnt'] == '5')?'selected':''; ?>>5마리</option>
                                    </select>

                                    <label class="input_label" for="cl_pet_cat">
                                        <input type="checkbox" name="cl_pet_cat" class="cl_pet_cat" id="cl_pet_cat" value="y" <?php echo ($write['cl_pet_cat'] == 'y')?'checked':''; ?>> 애완묘
                                    </label>
                                    <select name="cl_pet_cat_cnt" id="cl_pet_cat_cnt" class="form_select">
                                        <option value="" <?php echo ($write['cl_pet_cat_cnt'] == '')?'selected':''; ?>>선택</option>
                                        <option value="1" <?php echo ($write['cl_pet_cat_cnt'] == '1')?'selected':''; ?>>1마리</option>
                                        <option value="2" <?php echo ($write['cl_pet_cat_cnt'] == '2')?'selected':''; ?>>2마리</option>
                                        <option value="3" <?php echo ($write['cl_pet_cat_cnt'] == '3')?'selected':''; ?>>3마리</option>
                                        <option value="4" <?php echo ($write['cl_pet_cat_cnt'] == '4')?'selected':''; ?>>4마리</option>
                                        <option value="5" <?php echo ($write['cl_pet_cat_cnt'] == '5')?'selected':''; ?>>5마리</option>
                                    </select>
                                </div>
                            </td>
                            <th>사전면접</th>
                            <td>
                                <select name="cl_prior_interview" id="cl_prior_interview" class="form_select">
                                    <option value="" <?php echo ($write['cl_prior_interview'] == '')?'selected':''; ?>>사전면접선택</option>
                                    <option value="없음" <?php echo ($write['cl_prior_interview'] == '없음')?'selected':''; ?>>없음</option>
                                    <option value="있음" <?php echo ($write['cl_prior_interview'] == '있음')?'selected':''; ?>>있음</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="x90">단가구분</th>
                            <td class="x220">
                                <input type="text" name="cl_unit_price" id="cl_unit_price" class="form_input price_input x100" oninput="inputNum(this.id)" maxlength="13" value="<?php echo $write['cl_unit_price'] ?>">
                            </td>
                            <th class="x90">합계금액</th>
                            <td>
                                <input type="text" name="cl_tot_price" id="cl_tot_price" class="form_input price_input x130" oninput="inputNum(this.id)" maxlength="13" value="<?php echo $write['cl_tot_price'] ?>">
                            </td>
                            <th class="x90">현금영수증</th>
                            <td>
                                <input type="text" name="cl_cash_receipt" id="cl_cash_receipt" class="form_input x130" value="<?php echo $write['cl_cash_receipt'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>추가요청사항</th>
                            <td colspan="5">
                                <textarea name="cl_memo3" id="cl_memo3" class="form_textarea y100"><?php echo $write['cl_memo3'] ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>특이사항</th>
                            <td colspan="5">
                                <textarea name="cl_memo1" id="cl_memo1" class="form_textarea"><?php echo $write['cl_memo1'] ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>취소사유</th>
                            <td colspan="5">
                                <textarea name="cl_memo2" id="cl_memo2" class="form_textarea"><?php echo $write['cl_memo2'] ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>

<script>
$(function(){
    $('.client_service_view').css('display', 'none');
    $('.client_service_view').filter("[client_service='<?php echo $write['client_service'] ?>']").css('display', 'table-row');

    $('.client_service_view_cell').css('display', 'none');
    $('.client_service_view_cell').filter("[client_service='<?php echo $write['client_service'] ?>']").css('display', 'table-cell');

        <?php if($client_service != '반찬') { ?>
            $('.option_view_cell').css('display', 'table-cell');
        <?php } ?>

    $(".date_api").datepicker(datepicker_option);
});
</script>