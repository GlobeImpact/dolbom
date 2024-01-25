<?php
$w = $_GET['w'];
$client_idx = $_GET['client_idx'];

$popup_tit = '고객접수등록';
if($w == 'u') $popup_tit = '고객접수수정';

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
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="client_idx" id="client_idx" value="<?php echo $client_idx ?>">
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
                        <th>주민번호<span class="required_txt">*</span></th>
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
                    <tr>
                        <th>출산유형<span class="required_txt">*</span></th>
                        <td>
                            <select name="cl_birth_type" id="cl_birth_type" class="form_select">
                                <option value="자연분만" <?php echo ($write['cl_birth_type'] == '자연분만')?'selected':''; ?>>자연분만</option>
                                <option value="수술" <?php echo ($write['cl_birth_type'] == '수술')?'selected':''; ?>>수술</option>
                            </select>
                        </td>
                        <th>출산예정일</th>
                        <td>
                            <input type="text" name="cl_birth_due_date" id="cl_birth_due_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_birth_due_date'] ?>">
                        </td>
                        <th>출산일</th>
                        <td colspan="3">
                            <input type="text" name="cl_birth_date" id="cl_birth_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_birth_date'] ?>">
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
                                <th>출산아기<span class="required_txt">*</span></th>
                                <td class="x130">
                                    <select name="cl_baby" id="cl_baby" class="form_select">
                                        <option value="단태아" <?php echo ($write['cl_baby'] == '단태아')?'selected':''; ?>>단태아</option>
                                        <option value="쌍생아" <?php echo ($write['cl_baby'] == '쌍생아')?'selected':''; ?>>쌍생아</option>
                                        <option value="삼태아 이상" <?php echo ($write['cl_baby'] == '삼태아 이상')?'selected':''; ?>>삼태아 이상</option>
                                        <option value="장애아" <?php echo ($write['cl_baby'] == '장애아')?'selected':''; ?>>장애아</option>
                                    </select>
                                </td>
                                <th class="x90">아기성별<span class="required_txt">*</span></th>
                                <td class="x130">
                                    <select name="cl_baby_gender" id="cl_baby_gender" class="form_select">
                                        <option value="여자" <?php echo ($write['cl_baby_gender'] == '여자')?'selected':''; ?>>여자</option>
                                        <option value="남자" <?php echo ($write['cl_baby_gender'] == '남자')?'selected':''; ?>>남자</option>
                                    </select>
                                </td>
                                <th class="x80">출산순위<span class="required_txt">*</span></th>
                                <td class="x130">
                                    <select name="cl_baby_count" id="cl_baby_count" class="form_select">
                                        <option value="첫째" <?php echo ($write['cl_baby_count'] == '첫째')?'selected':''; ?>>첫째</option>
                                        <option value="둘째" <?php echo ($write['cl_baby_count'] == '둘째')?'selected':''; ?>>둘째</option>
                                        <option value="셋째" <?php echo ($write['cl_baby_count'] == '셋째')?'selected':''; ?>>셋째</option>
                                        <option value="넷째" <?php echo ($write['cl_baby_count'] == '넷째')?'selected':''; ?>>넷째</option>
                                        <option value="다섯째" <?php echo ($write['cl_baby_count'] == '다섯째')?'selected':''; ?>>다섯째</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>큰아들 돌보기</th>
                                <td>
                                    <select name="cl_baby_first" id="cl_baby_first" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_baby_first'] == '없음')?'selected':''; ?>>없음</option>
                                        <option value="있음" <?php echo ($write['cl_baby_first'] == '있음')?'selected':''; ?>>있음</option>
                                    </select>
                                </td>
                                <th>취학/미취학</th>
                                <td colspan="3">
                                    <select name="cl_school" id="cl_school" class="form_select">
                                        <option value="" <?php echo ($write['cl_school'] == '')?'selected':''; ?>>취학선택</option>
                                        <option value="1" <?php echo ($write['cl_school'] == '1')?'selected':''; ?>>1명</option>
                                        <option value="2" <?php echo ($write['cl_school'] == '2')?'selected':''; ?>>2명</option>
                                        <option value="3" <?php echo ($write['cl_school'] == '3')?'selected':''; ?>>3명</option>
                                        <option value="4" <?php echo ($write['cl_school'] == '4')?'selected':''; ?>>4명</option>
                                        <option value="5" <?php echo ($write['cl_school'] == '5')?'selected':''; ?>>5명</option>
                                    </select>
                                    <select name="cl_preschool" id="cl_preschool" class="form_select">
                                        <option value="" <?php echo ($write['cl_preschool'] == '')?'selected':''; ?>>미취학선택</option>
                                        <option value="1" <?php echo ($write['cl_preschool'] == '1')?'selected':''; ?>>1명</option>
                                        <option value="2" <?php echo ($write['cl_preschool'] == '2')?'selected':''; ?>>2명</option>
                                        <option value="3" <?php echo ($write['cl_preschool'] == '3')?'selected':''; ?>>3명</option>
                                        <option value="4" <?php echo ($write['cl_preschool'] == '4')?'selected':''; ?>>4명</option>
                                        <option value="5" <?php echo ($write['cl_preschool'] == '5')?'selected':''; ?>>5명</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>CCTV</th>
                                <td>
                                    <select name="cl_cctv" id="cl_cctv" class="form_select">
                                        <option value="" <?php echo ($write['cl_cctv'] == '')?'selected':''; ?>>없음</option>
                                        <option value="y" <?php echo ($write['cl_cctv'] == 'y')?'selected':''; ?>>있음</option>
                                    </select>
                                </td>
                                <th>반려동물</th>
                                <td colspan="3">
                                    <select name="cl_pet" id="cl_pet" class="form_select">
                                        <option value="없음" <?php echo ($write['cl_pet'] == '없음')?'selected':''; ?>>없음</option>
                                        <option value="애완견" <?php echo ($write['cl_pet'] == '애완견')?'selected':''; ?>>애완견</option>
                                        <option value="애완묘" <?php echo ($write['cl_pet'] == '애완묘')?'selected':''; ?>>애완묘</option>
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
                                <th>대여물품</th>
                                <td colspan="5">
                                    <div class="item_write_wrap">
                                        <div class="item_write_box">
                                            <label class="input_label" for="cl_item1_use"><input type="checkbox" name="cl_item1_use" id="cl_item1_use" value="y" <?php echo ($write['cl_item1_use'] == 'y')?'checked':''; ?>> 유축기</label>
                                            <input type="text" name="cl_item1_num" id="cl_item1_num" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_item1_num'] ?>" placeholder="번호">
                                            <input type="text" name="cl_item1_date" id="cl_item1_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_item1_date'] ?>" placeholder="대여일">
                                            <input type="text" name="cl_item1_name" id="cl_item1_name" class="form_input x80" maxlength="10" value="<?php echo $write['cl_item1_name'] ?>" placeholder="대여자">
                                            <input type="text" name="cl_item1_return_date" id="cl_item1_return_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_item1_return_date'] ?>" placeholder="반납일">
                                            <input type="text" name="cl_item1_return_name" id="cl_item1_return_name" class="form_input x80" maxlength="10" value="<?php echo $write['cl_item1_return_name'] ?>" placeholder="반납자">
                                        </div>
                                        <div class="item_write_box">
                                            <label class="input_label" for="cl_item2_use"><input type="checkbox" name="cl_item2_use" id="cl_item2_use" value="y" <?php echo ($write['cl_item2_use'] == 'y')?'checked':''; ?>> 좌욕기</label>
                                            <input type="text" name="cl_item2_num" id="cl_item2_num" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_item2_num'] ?>" placeholder="번호">
                                            <input type="text" name="cl_item2_date" id="cl_item2_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_item2_date'] ?>" placeholder="대여일">
                                            <input type="text" name="cl_item2_name" id="cl_item2_name" class="form_input x80" maxlength="10" value="<?php echo $write['cl_item1_name'] ?>" placeholder="대여자">
                                            <input type="text" name="cl_item2_return_date" id="cl_item2_return_date" class="form_input x80 date_api" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['cl_item2_return_date'] ?>" placeholder="반납일">
                                            <input type="text" name="cl_item2_return_name" id="cl_item2_return_name" class="form_input x80" maxlength="10" value="<?php echo $write['cl_item2_return_name'] ?>" placeholder="반납자">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>단가구분</th>
                                <td>
                                    <input type="text" name="cl_unit_price" id="cl_unit_price" class="form_input x100" oninput="autoHyphen(this)" maxlength="13" value="<?php echo $write['cl_unit_price'] ?>">
                                </td>
                                <th>합계금액</th>
                                <td colspan="3">
                                    <input type="text" name="cl_tot_price" id="cl_tot_price" class="form_input x130" oninput="autoHyphen(this)" maxlength="13" value="<?php echo $write['cl_tot_price'] ?>">
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
    $(".date_api").datepicker(datepicker_option);
});
</script>