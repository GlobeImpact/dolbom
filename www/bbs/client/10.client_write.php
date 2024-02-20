<?php
$w = $_GET['w'];
$client_idx = $_GET['client_idx'];

$popup_tit = '고객접수등록';
if($w == 'u') $popup_tit = '고객접수수정';

if($w == '') {
    $client_service = '';
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
    if($write['cl_item1_date'] == '0000-00-00') $write['cl_item1_date'] = '';
    if($write['cl_item1_return_date'] == '0000-00-00') $write['cl_item1_return_date'] = '';
    if($write['cl_item2_date'] == '0000-00-00') $write['cl_item2_date'] = '';
    if($write['cl_item2_return_date'] == '0000-00-00') $write['cl_item2_return_date'] = '';

    $client_service = $write['client_service'];
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <?php if($w == '') { ?>
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
            <h4 class="layer_popup_tit">고객접수 기본정보</h4>
            
            <table class="write_tbl">
                <tbody>
                    <tr> 
                        <th class="x90">접수일자<span class="required_txt">*</span></th>
                        <td class="x165">
                            <input type="text" name="receipt_date" id="receipt_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['receipt_date'] ?>">
                        </td>
                        <th class="x90">시작일자</th>
                        <td class="x165">
                            <input type="text" name="str_date" id="str_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['str_date'] ?>">
                        </td>
                        <th class="x90">종료일자</th>
                        <td class="x165">
                            <input type="text" name="end_date" id="end_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['end_date'] ?>">
                        </td>
                        <th class="x90">취소일자</th>
                        <td>
                            <input type="text" name="cancel_date" id="cancel_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cancel_date'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>신청인<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="cl_name" id="cl_name" class="form_input x130" value="<?php echo $write['cl_name'] ?>">
                        </td>
                        <th>주민번호</th>
                        <td>
                            <input type="text" name="cl_security_number" id="cl_security_number" class="form_input x130" value="<?php echo $write['cl_security_number'] ?>" oninput="autoHyphen2(this)" maxlength="14">
                        </td>
                        <th>연락처<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="cl_hp" id="cl_hp" class="form_input x130" value="<?php echo $write['cl_hp'] ?>" oninput="autoHyphen(this)" maxlength="13">
                        </td>
                        <th>긴급연락처</th>
                        <td>
                            <input type="text" name="cl_tel" id="cl_tel" class="form_input x130" value="<?php echo $write['cl_tel'] ?>" oninput="autoHyphen(this)" maxlength="13">
                        </td>
                    </tr>
                    <tr class="client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0] ?>">
                        <th>가족관계</th>
                        <td>
                            <input type="text" name="cl_relationship" id="cl_relationship" class="form_input x130" value="<?php echo $write['cl_relationship'] ?>">
                        </td>
                        <th>아기이름</th>
                        <td>
                            <input type="text" name="cl_baby_name" id="cl_baby_name" class="form_input x130" value="<?php echo $write['cl_baby_name'] ?>">
                        </td>
                        <th>아기생년월일</th>
                        <td>
                            <input type="text" name="cl_baby_birth" id="cl_baby_birth" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_baby_birth'] ?>">
                        </td>
                        <th>아기성별</th>
                        <td>
                            <select name="cl_baby_gender" id="cl_baby_gender" class="form_select">
                                <option value="여자" <?php echo ($write['cl_baby_gender'] == '여자')?'selected':''; ?>>여자</option>
                                <option value="남자" <?php echo ($write['cl_baby_gender'] == '남자')?'selected':''; ?>>남자</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>주소</th>
                        <td colspan="7">
                            <div class="div_flex">
                                <input type="text" name="cl_zip" id="cl_zip" class="form_input" size="5" maxlength="6" placeholder="우편번호" value="<?php echo $write['cl_zip'] ?>">
                                <button type="button" class="btn_frm_addr" onclick="win_zip('fregisterform', 'cl_zip', 'cl_addr1', 'cl_addr2', 'cl_addr3', 'cl_addr_jibeon');">주소 검색</button>
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
                    <tr>
                        <th>특이사항</th>
                        <td colspan="7">
                            <textarea name="cl_memo1" id="cl_memo1" class="form_textarea"><?php echo $write['cl_memo1'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>취소사유</th>
                        <td colspan="7">
                            <textarea name="cl_memo2" id="cl_memo2" class="form_textarea"><?php echo $write['cl_memo2'] ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex_row_between">
                <div>
                    <h4 class="layer_tit mtop20">고객접수 서비스정보</h4>

                    <table class="write_tbl">
                        <tbody>
                            <tr>
                                <th class="x110">서비스구분<span class="required_txt">*</span></th>
                                <td colspan="5">
                                    <select name="cl_service_cate" id="cl_service_cate" class="form_select">
                                        <option value="" <?php echo ($write['cl_service_cate'] == '')?'selected':''; ?>>서비스구분선택</option>
                                        <option value="바우처" <?php echo ($write['cl_service_cate'] == '바우처')?'selected':''; ?>>바우처</option>
                                        <option value="유료" <?php echo ($write['cl_service_cate'] == '유료')?'selected':''; ?>>유료</option>
                                        <option value="프리랜서" <?php echo ($write['cl_service_cate'] == '프리랜서')?'selected':''; ?>>프리랜서</option>
                                        <option value="기타" <?php echo ($write['cl_service_cate'] == '기타')?'selected':''; ?>>기타</option>
                                    </select>
                                    <select name="cl_service_cate2" id="cl_service_cate2" class="form_select" <?php echo ($write['cl_service_cate'] != '바우처')?'style="display:none;"':''; ?>>
                                        <option value="바우처 #1" <?php echo ($write['cl_service_cate2'] == '바우처 #1')?'selected':''; ?>>바우처 #1</option>
                                        <option value="바우처 #2" <?php echo ($write['cl_service_cate2'] == '바우처 #2')?'selected':''; ?>>바우처 #2</option>
                                        <option value="바우처 #3" <?php echo ($write['cl_service_cate2'] == '바우처 #3')?'selected':''; ?>>바우처 #3</option>
                                        <option value="바우처 #4" <?php echo ($write['cl_service_cate2'] == '바우처 #4')?'selected':''; ?>>바우처 #4</option>
                                        <option value="바우처 #5" <?php echo ($write['cl_service_cate2'] == '바우처 #5')?'selected':''; ?>>바우처 #5</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>서비스기간</th>
                                <td colspan="3">
                                    <input type="text" name="cl_service_str_date" id="cl_service_str_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_service_str_date'] ?>"> ~ 
                                    <input type="text" name="cl_service_end_date" id="cl_service_end_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_service_end_date'] ?>">
                                </td>
                                <th>서비스시간</th>
                                <td>
                                    <select name="cl_service_time" id="cl_service_time">
                                        <option value="" <?php echo ($write['cl_service_time'] == '')?'selected':''; ?>>시간선택</option>
                                        <option value="4" <?php echo ($write['cl_service_time'] == '4')?'selected':''; ?>>4시간</option>
                                        <option value="8" <?php echo ($write['cl_service_time'] == '8')?'selected':''; ?>>8시간</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0] ?>">
                                <th>출산순위</th>
                                <td colspan="3">
                                    <select name="cl_baby_count" id="cl_baby_count" class="form_select">
                                        <option value="" <?php echo ($write['cl_baby_count'] == '')?'selected':''; ?>>출산순위선택</option>
                                        <option value="첫째" <?php echo ($write['cl_baby_count'] == '첫째')?'selected':''; ?>>첫째</option>
                                        <option value="둘째" <?php echo ($write['cl_baby_count'] == '둘째')?'selected':''; ?>>둘째</option>
                                        <option value="셋째" <?php echo ($write['cl_baby_count'] == '셋째')?'selected':''; ?>>셋째</option>
                                        <option value="넷째" <?php echo ($write['cl_baby_count'] == '넷째')?'selected':''; ?>>넷째</option>
                                        <option value="다섯째" <?php echo ($write['cl_baby_count'] == '다섯째')?'selected':''; ?>>다섯째</option>
                                    </select>
                                </td>
                                <th>추가서비스</th>
                                <td>
                                    <select name="cl_add_service0" id="cl_add_service0" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_add_service0'] == '없음')?'selected':''; ?>>없음</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[1] ?>">
                                <th>집면적</th>
                                <td colspan="3">
                                    <select name="cl_house_area" id="cl_house_area" class="form_select">
                                        <option value="" <?php echo ($write['cl_house_area'] == '')?'selected':''; ?>>집면적선택</option>
                                        <option value="9평이하" <?php echo ($write['cl_house_area'] == '9평이하')?'selected':''; ?>>9평이하</option>
                                        <option value="10~19평" <?php echo ($write['cl_house_area'] == '10~19평')?'selected':''; ?>>10~19평</option>
                                        <option value="20~35평" <?php echo ($write['cl_house_area'] == '20~35평')?'selected':''; ?>>20~35평</option>
                                        <option value="36~45평" <?php echo ($write['cl_house_area'] == '36~45평')?'selected':''; ?>>36~45평</option>
                                        <option value="46평이상" <?php echo ($write['cl_house_area'] == '46평이상')?'selected':''; ?>>46평이상</option>
                                    </select>
                                </td>
                                <th>추가서비스</th>
                                <td>
                                    <select name="cl_add_service1" id="cl_add_service1" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_add_service1'] == '없음')?'selected':''; ?>>없음</option>
                                        <option value="다림질" <?php echo ($write['cl_add_service1'] == '다림질')?'selected':''; ?>>다림질</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[2] ?>">
                                <th>상품구분</th>
                                <td colspan="3">
                                    <select name="cl_product" id="cl_product" class="form_select">
                                        <option value="" <?php echo ($write['cl_product'] == '')?'selected':''; ?>>상품구분선택</option>
                                        <option value="국+반찬(3가지)" <?php echo ($write['cl_product'] == '국+반찬(3가지)')?'selected':''; ?>>국+반찬(3가지)</option>
                                        <option value="국+반찬(3가지)+찌개OR조림" <?php echo ($write['cl_product'] == '국+반찬(3가지)+찌개OR조림')?'selected':''; ?>>국+반찬(3가지)+찌개OR조림</option>
                                        <option value="국+반찬(3가지)+특식" <?php echo ($write['cl_product'] == '국+반찬(3가지)+특식')?'selected':''; ?>>국+반찬(3가지)+특식</option>
                                    </select>
                                </td>
                                <th>추가서비스</th>
                                <td>
                                    <select name="cl_add_service2" id="cl_add_service2" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_add_service2'] == '없음')?'selected':''; ?>>없음</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>CCTV</th>
                                <td class="x130">
                                    <select name="cl_cctv" id="cl_cctv" class="form_select">
                                        <option value="" <?php echo ($write['cl_cctv'] == '')?'selected':''; ?>>없음</option>
                                        <option value="y" <?php echo ($write['cl_cctv'] == 'y')?'selected':''; ?>>있음</option>
                                    </select>
                                </td>
                                <th class="x90">반려동물</th>
                                <td class="x130">
                                    <select name="cl_pet" id="cl_pet" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_pet'] == '없음')?'selected':''; ?>>없음</option>
                                        <option value="애완견" <?php echo ($write['cl_pet'] == '애완견')?'selected':''; ?>>애완견</option>
                                        <option value="애완묘" <?php echo ($write['cl_pet'] == '애완묘')?'selected':''; ?>>애완묘</option>
                                    </select>
                                </td>
                                <th class="x90">사전면접</th>
                                <td class="x130">
                                    <select name="cl_prior_interview" id="cl_prior_interview" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_prior_interview'] == '없음')?'selected':''; ?>>없음</option>
                                        <option value="있음" <?php echo ($write['cl_prior_interview'] == '있음')?'selected':''; ?>>있음</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>추가요금부담</th>
                                <td>
                                    <select name="cl_surcharge" id="cl_surcharge" class="form_select">
                                        <option value="불가능" <?php echo ($write['cl_surcharge'] == '불가능')?'selected':''; ?>>불가능</option>
                                        <option value="가능" <?php echo ($write['cl_surcharge'] == '가능')?'selected':''; ?>>가능</option>
                                    </select>
                                </td>
                                <th>프리미엄</th>
                                <td colspan="3">
                                    <label class="input_label" for="cl_premium_use"><input type="checkbox" name="cl_premium_use" id="cl_premium_use" value="y" <?php echo ($write['cl_premium_use'] == 'y')?'checked':''; ?>>프리미엄</label>
                                </td>
                            </tr>
                            <tr>
                                <th>단가구분</th>
                                <td>
                                    <input type="text" name="cl_unit_price" id="cl_unit_price" class="form_input x100" oninput="inputNum(this)" maxlength="13" value="<?php echo $write['cl_unit_price'] ?>">
                                </td>
                                <th>합계금액</th>
                                <td colspan="3">
                                    <input type="text" name="cl_tot_price" id="cl_tot_price" class="form_input x130" oninput="inputNum(this)" maxlength="13" value="<?php echo $write['cl_tot_price'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>추가요청사항</th>
                                <td colspan="5">
                                    <textarea name="cl_memo3" id="cl_memo3" class="form_textarea"><?php echo $write['cl_memo3'] ?></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex1 mleft10">
                    <h4 class="layer_tit mtop20">고객접수 관리사정보</h4>

                    <table class="write_tbl">
                        <tbody>
                            <tr>
                                <th class="x100">지정 관리사</th>
                                <td>
                                    <button type="button" id="receipt_btn">관리사 선택</button>
                                    <ul id="form_receipt_box">
                                        <li class="receipt_list">
                                            <a>
                                                <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                            </a>
                                        </li>
                                        <li class="receipt_list">
                                            <a>
                                                <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                            </a>
                                        </li>
                                        <li class="receipt_list">
                                            <a>
                                                <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                            </a>
                                        </li>
                                        <li class="receipt_list">
                                            <a>
                                                <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>파견 관리사</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>변경 관리사</th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>

    <a id="client_submit_btn">저장하기</a>
</div>

<script>
$(function(){
    <?php if($w == 'u') { ?>
    $('.client_service_view').css('display', 'none');
    $('.client_service_view').filter("[client_service='<?php echo $write['client_service'] ?>']").css('display', 'table-row');
    <?php } ?>
});

$(function(){
    $(".date_api").datepicker(datepicker_option);
});
</script>